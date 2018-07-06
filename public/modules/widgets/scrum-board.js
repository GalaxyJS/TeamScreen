/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const apiService = Scope.import('services/api.js');

const statusesTypes = {};
Scope.data.columns = [];
Scope.data.issues = [];

apiService.getBoardConfiguration(122).then(function (data) {
  Scope.data.columns = data.columnConfig.columns;
  Scope.data.columns.forEach(function (item) {
    statusesTypes[item.name] = item.statuses.map(function (status) {
      return status.id;
    });
  });
});

apiService.getSprintIssues(836).then(function (data) {
  Scope.data.issues = data.issues;
});

Scope.data.activeSprint = {
  "id": 836,
  "self": "https://jira.local.mybit.nl/rest/agile/1.0/sprint/836",
  "state": "active",
  "name": "3Dimerce 2018 - Sprint 14",
  "startDate": "2018-07-02T09:50:41.750+02:00",
  "endDate": "2018-07-20T09:50:00.000+02:00",
  "originBoardId": 122,
  "goal": "Bert vertalingen, LEO afronding zitmeubelen, Portal Reorder Choices & FBX viewer, Add JIRA to scrumboard"
};

detectTypeOfColumn.watch = ['column'];

const toDoClasses = ['to do', 'To Do', 'ToDo', 'Todo'];
const devClasses = ['In Development', 'In development', 'in development', 'In Dev'];
const reviewClasses = ['In Review', 'Review', 'review', 'Code Review'];
const readyForQAClasses = ['Ready For QA', 'Ready for QA', 'Ready For Q&A'];
const qaClasses = ['QA', 'Q&A'];
const doneClasses = ['Done', 'done', 'Done/Accept/Closed'];

function detectTypeOfColumn(column) {
  const name = column.name;
  const result = ['column'];

  if (toDoClasses.indexOf(name) !== -1) {
    result.push('to-do');
  }

  if (devClasses.indexOf(name) !== -1) {
    result.push('in-development');
  }

  if (reviewClasses.indexOf(name) !== -1) {
    result.push('review');
  }

  if (readyForQAClasses.indexOf(name) !== -1) {
    result.push('ready-for-qa');
  }

  if (qaClasses.indexOf(name) !== -1) {
    result.push('qa');
  }

  if (doneClasses.indexOf(name) !== -1) {
    result.push('done');
  }

  return result;
}

getColumnIssues.watch = ['data.issues.changes', 'column']

function getColumnIssues(issuesArrayChange, column) {
  const typeIds = statusesTypes[column.name];
  if (issuesArrayChange.params.length) {
    issuesArrayChange.params = issuesArrayChange.original.filter(function (issue) {
      return typeIds.indexOf(issue.fields.status.id) !== -1;
    })
  }

  return issuesArrayChange;
}

view.init({
  class: 'container-row ',
  children: {
    class: 'widget width-full scrum-board',
    children: [
      {
        tag: 'h2',
        text: 'Scrumboard Team 3DImerce'
      },
      {
        class: 'content container-row',
        children: {
          tag: 'section',
          class: detectTypeOfColumn,

          $for: {
            data: '<>data.columns.changes',
            as: 'column'
          },

          inputs: {
            colName: '<>column.name'
          },

          animations: {
            enter: {
              sequence: 'columns',
              from: {
                y: 50,
                opacity: 0
              },
              // to: {
              //   scale: 1,
              //   opacity: 1
              // },
              position: '-=.3',
              duration: .5
            }
          },

          children: [
            {
              tag: 'h3',
              text: '<>column.name'

            },
            {
              tag: 'div',
              class: 'task',

              animations: {
                enter: {
                  parent: 'columns',
                  sequence: 'tasks',
                  from: {
                    scale: .5,
                    opacity: 0
                  },
                  to: {
                    scale: 1,
                    opacity: 1
                  },
                  position: '-=.2',
                  duration: .3
                }
              },

              $for: {
                data: getColumnIssues,
                as: 'issue'
              },

              children: [
                {
                  tag: 'h4',
                  text: '<>issue.key'
                },
                {
                  tag: 'p',
                  text: '<>issue.fields.summary'
                },
                {
                  class: 'icon',
                  tag: 'img',
                  animations: {
                    enter: {
                      parent: 'columns',
                      sequence: 'icons',
                      from: {
                        scale: 0
                      },
                      duration: .3
                    }
                  },
                  $if: '<>issue.fields.assignee',
                  src: '<>issue.fields.assignee.avatarUrls.48x48'
                }
              ]
            }
          ]
        }
      }
    ]
  }
});