/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const apiService = Scope.import('services/api.js');
const appService = Scope.import('services/app.js');

const animations = Scope.import('services/animations.js');

const statusesTypes = {};

Scope.data.appService = appService;
Scope.data.columns = [];
Scope.data.issues = [];

Scope.data.activeSprint = {
  // "id": 836,
  // "self": "https://jira.local.mybit.nl/rest/agile/1.0/sprint/836",
  // "state": "active",
  // "name": "3Dimerce 2018 - Sprint 14",
  // "startDate": "2018-07-02T09:50:41.750+02:00",
  // "endDate": "2018-07-20T09:50:00.000+02:00",
  // "originBoardId": 122,
  // "goal": "Bert vertalingen, LEO afronding zitmeubelen, Portal Reorder Choices & FBX viewer, Add JIRA to scrumboard"
};

getActiveSprint.watch = ['data.appService.activeTeam'];

function getActiveSprint(activeTeam) {
  if (activeTeam && activeTeam.board_id) {
    apiService.getActiveSprint(activeTeam.board_id).then(function (data) {
      Scope.data.activeSprint = data.values[0];
    });
  } else {
    Scope.data.activeSprint = {
      name: ''
    };
  }
}

getBoardConfiguration.watch = ['data.appService.activeTeam'];
let colm = []

function getBoardConfiguration(activeTeam) {
  if (activeTeam && activeTeam.board_id) {
    apiService.getBoardConfiguration(activeTeam.board_id).then(function (data) {
      Scope.data.issues = [];
      colm = data.columnConfig.columns;
      colm.forEach(function (item) {
        statusesTypes[item.name] = item.statuses.map(function (status) {
          return status.id;
        });
      });
    });
  } else {
    Scope.data.columns = [];
  }
}

getSprintIssues.watch = ['data.activeSprint'];

function getSprintIssues(activeSprint) {
  if (activeSprint && activeSprint.id) {
    apiService.getSprintIssues(activeSprint.id).then(function (data) {
      Scope.data.issues = data.issues;
      Scope.data.columns = colm;
    });
  } else {
    Scope.data.issues = [];
  }
}

const toDoClasses = ['to do', 'To Do', 'ToDo', 'Todo'];
const devClasses = ['In Development', 'In development', 'in development', 'In Dev'];
const reviewClasses = ['In Review', 'Review', 'review', 'Code Review'];
const readyForQAClasses = ['Ready For QA', 'Ready for QA', 'Ready For Q&A'];
const qaClasses = ['QA', 'Q&A'];
const doneClasses = ['Done', 'done', 'Done/Accept/Closed'];

detectTypeOfColumn.watch = ['column'];

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

getColumnIssues.watch = ['data.issues.changes', 'column'];

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
  app_activeSprint: getActiveSprint,
  app_boardConfiguration: getBoardConfiguration,
  app_issues: getSprintIssues,

  animations: {
    enter: {
      // parent: animations.widgetEnter.parent,
      sequence: animations.widgetEnter.sequence,
      from: {
        y: 20,
        opacity: 0
      },
      duration: .2
    },
    leave: {
      sequence: animations.widgetEnter.sequence,
      from: {
        position: 'absolute',
        width: '100%'
      },
      to: {
        opacity: 0,
        display: 'none'
      },
      position: '-=.2',
      duration: 0.6
    }
  },
  class: 'container-column scrum-board',

  children: [
    {
      tag: 'h2',
      html: [
        'data.activeSprint',
        function (sprint) {
          return 'Scrumboard ' + sprint.name + ': <span>' + (sprint.goal || '') + '</span>';
        }
      ]
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
            // parent: animations.widgetEnter.sequence,
            sequence: 'columns',
            from: {
              y: 50,
              opacity: 0
            },
            // to: {
            //   scale: 1,
            //   opacity: 1
            // },
            position: '-=.2',
            duration: .3
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

            inputs: {
              columnName: '<>column.name'
            },

            animations: {
              enter: {
                parent: 'columns',
                // parent: function () {
                //   return 'columns-' + this.parent.inputs.colName;
                // },
                // chainToParent: true,
                sequence: function () {
                  // console.log('tasks-' + this.inputs.columnName);
                  return 'columns-' + this.parent.inputs.colName;
                },
                from: {
                  scale: .5,
                  opacity: 0
                },
                to: {
                  scale: 1,
                  opacity: 1
                },
                position: '-=.16',
                duration: .2
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
                // animations: {
                //   enter: {
                //     parent: 'columns',
                //     sequence: 'icons',
                //     from: {
                //       scale: 0
                //     },
                //     duration: .3
                //   }
                // },
                $if: '<>issue.fields.assignee',
                src: '<>issue.fields.assignee.avatarUrls.48x48'
              }
            ]
          }
        ]
      }
    }
  ]
  // }
});