const view = Scope.import('galaxy/view');
const inputs = Scope.import('galaxy/inputs');
const router = Scope.parentScope.import('galaxy/router');
const apiService = Scope.import('services/api.js');
const animations = Scope.import('services/animations.js');
const utility = Scope.import('services/utility.js');

apiService.getAllTeams().then(function (teams) {
  Scope.data.teams = teams;
});

if (inputs.data.params && inputs.data.params.id) {
  apiService.getMemberById(inputs.data.params.id).then(function (data) {
    Scope.data.form = data;
  });
}

Scope.data.form = {
  id: null,
  name: null,
  username: null,
  team_id: null,
  destination: '',
  drink_preference: null,
  working_days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']
};

view.init({
  tag: 'form',
  method: 'post',
  class: 'form',
  on: {
    submit: function (event) {
      event.preventDefault();
      if (Scope.data.form.id) {
        apiService.updateMember(Scope.data.form).then(function (data) {
          console.info('Member updated successfully', data);
          router.navigateFromHere('/');
        });
      } else {
        apiService.addMember(Scope.data.form).then(function (data) {
          console.info('Member added successfully', data);
          router.navigateFromHere('/');
        });
      }
    }
  },
  animations: {
    enter: animations.formEnter,
    leave: animations.formLeave
  },
  children: [
    {
      tag: 'h2',
      html: [
        'data.form',
        function (form) {
          return form.id ? 'Member Info' : 'New Member';
        }
      ]
    },
    {
      class: 'content',
      children: [
        {
          class: 'info',
          $if: '<>data.form.username',
          children: [
            {
              animations: {
                '@loaded': {
                  parent: true,
                  sequence: 'icon',
                  from: {
                    scale: 0
                  },
                  to: {
                    scale: 1
                  },
                  duration: .2
                }
              },
              class: {
                avatar: true,
                big: true,
                '@loaded': '<>this.loaded'
              },
              tag: 'img',
              src: [
                'data.form.username',
                utility.avatarURL.big
              ],
              on: {
                load: function () {
                  this.data.loaded = true;
                }
              }
            },
            {
              tag: 'strong',
              text: '<>data.form.name'
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'Name'
            },
            {
              tag: 'input',
              name: 'name',
              required: 'true',
              value: '<>data.form.name',

              lifecycle: {
                postInsert: function () {
                  this.node.focus();
                }
              }
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'JIRA Username'
            },
            {
              tag: 'input',
              name: 'username',
              value: '<>data.form.username',
              required: 'true'
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'Team'
            },
            {
              tag: 'select',
              name: 'team_id',
              selected: '<>data.form.team_id',
              children: [
                {
                  tag: 'option',
                  value: '',
                  text: 'None'
                },

                {
                  tag: 'option',

                  $for: {
                    data: '<>data.teams.changes',
                    as: 'team'
                  },

                  value: '<>team.id',
                  text: '<>team.name'
                }
              ]
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'Destination'
            },
            {
              tag: 'input',
              name: 'destination',
              value: '<>data.form.destination'
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'Drink preference'
            },
            {
              tag: 'select',
              name: 'drink_preference',
              selected: '<>data.form.drink_preference',
              children: [
                {
                  tag: 'option',
                  value: '',
                  text: 'none'
                },
                {
                  tag: 'option',
                  value: 'coffee',
                  text: 'Coffee'
                },
                {
                  tag: 'option',
                  value: 'tea',
                  text: 'Tea'
                },
                {
                  tag: 'option',
                  value: 'water',
                  text: 'Water'
                }
              ]
            }
          ]
        },
        {
          tag: 'div',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'Working days'
            },
            {
              class: 'values',
              children: [
                {
                  tag: 'label',
                  class: 'checkbox',
                  text: 'Monday',
                  children: {
                    tag: 'input',
                    type: 'checkbox',
                    name: 'working_days[]',
                    value: 'monday',
                    checked: '<>data.form.working_days'
                  }
                },
                {
                  tag: 'label',
                  class: 'checkbox',
                  text: 'Tuesday',
                  children: {
                    tag: 'input',
                    type: 'checkbox',
                    name: 'working_days[]',
                    value: 'tuesday',
                    checked: '<>data.form.working_days'
                  }
                },
                {
                  tag: 'label',
                  class: 'checkbox',
                  text: 'Wednesday',
                  children: {
                    tag: 'input',
                    type: 'checkbox',
                    name: 'working_days[]',
                    value: 'wednesday',
                    checked: '<>data.form.working_days'
                  }
                },
                {
                  tag: 'label',
                  class: 'checkbox',
                  text: 'Thursday',
                  children: {
                    tag: 'input',
                    type: 'checkbox',
                    name: 'working_days[]',
                    value: 'thursday',
                    checked: '<>data.form.working_days'
                  }
                },
                {
                  tag: 'label',
                  class: 'checkbox',
                  text: 'Friday',
                  children: {
                    tag: 'input',
                    type: 'checkbox',
                    name: 'working_days[]',
                    value: 'friday',
                    checked: '<>data.form.working_days'
                  }
                }
              ]
            }
          ]
        }
      ]
    },
    {
      tag: 'footer',
      children: [
        {
          tag: 'button',
          text: 'Save',
          type: 'submit'
        }
      ]
    }
  ]
});