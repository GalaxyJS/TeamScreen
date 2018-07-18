const view = Scope.import('galaxy/view');
const parentRouter = Scope.parentScope.import('galaxy/router');
const inputs = Scope.import('galaxy/inputs');

const apiService = Scope.import('services/api.js');
const animations = Scope.import('services/animations.js');

Scope.data.form = {
  name: null,
  board_id: null
};

if (inputs.data.params && inputs.data.params.id) {
  apiService.getTeamById(inputs.data.params.id).then(function (data) {
    Scope.data.form = data;
  });
}

view.init({
  tag: 'form',
  method: 'post',
  class: 'form',
  on: {
    submit: function (event) {
      event.preventDefault();
      if(Scope.data.form.id) {
        apiService.updateTeam(Scope.data.form).then(function (data) {
          console.info('Team updated successfully', data);
          parentRouter.navigateFromHere('/');
        });
      } else {
        apiService.addTeam(Scope.data.form).then(function (data) {
          console.info('Team added successful', data);
          parentRouter.navigateFromHere('/');
        });
      }
    }
  },
  animations: {
    enter: animations.formEnter,
    leave: animations.formLeave,
  },
  children: [
    {
      tag: 'h2',
      html: [
        'data.form',
        function (form) {
          return form.id ? 'Team Info: <span>' + form.name + '</span>' : 'New Team';
        }
      ]
    },
    {
      class: 'content',
      children: [
        {
          tag: 'label',
          class: 'field',

          children: [
            {
              tag: 'span',
              text: 'Team name'
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
              },
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',
          children: [
            {
              tag: 'span',
              text: 'JIRA Board ID'
            },
            {
              tag: 'select',
              name: 'board_id',
              selected: '<>data.form.board_id',
              children: [
                {
                  tag: 'option',
                  value: '',
                  text: 'none'
                },
                {
                  tag: 'option',
                  value: 122,
                  text: '3dimerce_team3 '
                },
                {
                  tag: 'option',
                  value: 84,
                  text: 'Mobile'
                },
                {
                  tag: 'option',
                  value: 95,
                  text: 'Notuback'
                },
                {
                  tag: 'option',
                  value: 149,
                  text: 'Notuweb'
                },
                {
                  tag: 'option',
                  value: 101,
                  text: 'VCS'
                }
              ]
            }
          ]
        },
      ]
    },
    {
      tag: 'footer',
      children: [
        {
          tag: 'button',
          text: 'Save',
          type: 'submit',
        }
      ]
    }
  ]
});