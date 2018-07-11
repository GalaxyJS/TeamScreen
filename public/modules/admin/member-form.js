const view = Scope.import('galaxy/view');

const router = Scope.parentScope.import('galaxy/router');

Scope.data.form = {
  name: null,
  username: null,
  team: null,
  destination: null,
  drink_preference: 'tea',
  working_days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']
};

view.init({
  tag: 'form',
  method: 'post',
  class: 'form',
  on: {
    submit: function (event) {
      event.preventDefault();
      fetch('/api/members', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(Scope.data.form)
      }).then(function (response) {
        if (response.status !== 200) {
          throw response;
        }

        response.json().then(function (data) {
          console.info('Member successful', data);
          router.navigateFromHere('/');
        });
      }).catch(function (error) {
        console.error(error);
        error.json().then(function (content) {
          console.error(JSON.stringify(content, null, ' '));
        });
      });
    }
  },
  animations: {
    enter: {
      from: {
        scale: .8,
        opacity: 0
      },
      duration: .3
    },
    leave: {
      to: {
        scale: .8,
        opacity: 0
      },
      duration: .1
    }
  },
  children: [
    {
      tag: 'h2',
      text: 'New Member'
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
              text: 'Name'
            },
            {
              tag: 'input',
              name: 'name',
              required: 'true',
              value: '<>data.form.name'
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
              type: 'email',
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
              children: [
                {
                  tag: 'option',
                  value: '',
                  text: 'None'
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