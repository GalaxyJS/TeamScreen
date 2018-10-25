const view = Scope.import('galaxy/view');
const parentRouter = Scope.parentScope.import('galaxy/router');
const inputs = Scope.import('galaxy/inputs');

const apiService = Scope.import('services/api.js');
const animations = Scope.import('services/animations.js');

Scope.data.form = {
  name: null,
  board_id: null,
  board_name: null
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
      if (Scope.data.form.id) {
        apiService.updateTeam(Scope.data.form).then(function (data) {
          console.info('Team updated successfully', data);
          view.broadcast(new CustomEvent('team-update', {
            bubbles: true
          }));
          parentRouter.navigateFromHere('/');
        });
      } else {
        apiService.addTeam(Scope.data.form).then(function (data) {
          console.info('Team added successful', data);
          view.broadcast(new CustomEvent('team-add', {
            bubbles: true
          }));
          parentRouter.navigateFromHere('/');
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
              text: 'JIRA Board ID'
            },
            {
              tag: 'input',
              name: 'board_id',
              required: 'true',
              value: '<>data.form.board_id',
            }
          ]
        },
        {
          tag: 'label',
          class: 'field',

          children: [
            {
              tag: 'span',
              text: 'Board name'
            },
            {
              tag: 'input',
              name: 'board_name',
              required: 'true',
              value: '<>data.form.board_name',
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