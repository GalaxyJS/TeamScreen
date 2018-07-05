/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');

Scope.data.columns = [
  {
    "name": "To Do",
    "statuses": [
      {
        "id": "10009",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10009"
      },
      {
        "id": "10105",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10105"
      },
      {
        "id": "1",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/1"
      },
      {
        "id": "10004",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10004"
      },
      {
        "id": "4",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/4"
      },
      {
        "id": "10000",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10000"
      },
      {
        "id": "10104",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10104"
      },
      {
        "id": "10804",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10804"
      }
    ]
  },
  {
    "name": "In Dev",
    "statuses": [
      {
        "id": "10007",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10007"
      },
      {
        "id": "10904",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10904"
      }
    ]
  },
  {
    "name": "Review",
    "statuses": [
      {
        "id": "10106",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10106"
      }
    ]
  },
  {
    "name": "Ready for QA",
    "statuses": [
      {
        "id": "10404",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10404"
      }
    ]
  },
  {
    "name": "QA",
    "statuses": [
      {
        "id": "10003",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10003"
      },
      {
        "id": "10405",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10405"
      }
    ]
  },
  {
    "name": "Done",
    "statuses": [
      {
        "id": "10010",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10010"
      },
      {
        "id": "10006",
        "self": "https://jira.local.mybit.nl/rest/api/2/status/10006"
      }
    ]
  }
];

detectTypeOfColumn.watch = ['column'];

const toDoClasses = ['to do', 'To Do', 'ToDo', 'Todo'];
const devClasses = ['In Development', 'In development', 'in development', 'In Dev'];
const reviewClasses = ['In Review', 'Review', 'review'];
const readyForQAClasses = ['Ready For QA', 'Ready for QA', 'Ready For Q&A'];
const qaClasses = ['QA', 'Q&A'];
const doneClasses = ['Done', 'done','Done/Accept/Closed'];

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
    result.push('in-development');
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

view.init([
  {
    class: 'widget full-width scrum-board',
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

          children: [
            {
              tag: 'h3',
              text: '<>column.name'
            },
            {
              tag: '',
              $for: {
                data: '<>columns.statuses',
                as: 'column'
              },
            }
          ]
        }
      }
    ]
  }
]);