const view = Scope.import('galaxy/view');
const router = Scope.parentScope.import('galaxy/router');
const apiService = Scope.import('services/api.js');

Scope.data.form = {
  name: null
};

view.init({
  tag: 'form',
  method: 'post',
  class: 'form',
  on: {
    submit: function (event) {
      event.preventDefault();
      apiService.saveTeam(Scope.data.form).then(function (data) {
        console.info('Team successful', data);
        router.navigateFromHere('/');
      });
    }
  },
  animations: {
    config: {
      leaveWithParent: true
    },
    enter: {
      sequence: 'overlay-form',
      from: {
        scale: .8,
        opacity: 0
      },
      duration: .3
    },
    leave: {
      sequence: 'overlay-form',
      to: {
        scale: .8,
        opacity: 0,
        display:'none'
      },
      duration: .1
    }
  },
  children: [
    {
      tag: 'h2',
      text: 'New Team'
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
      ]
    },
    {
      tag: 'footer',
      children: [
        {
          tag: 'button',
          text: 'Save',
          type: 'submit',
          on: {
            click: function () {

              // alert('as')
            }
          }
        }
      ]
    }
  ]
});