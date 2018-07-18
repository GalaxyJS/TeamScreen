const view = Scope.import('galaxy/view');
const router = Scope.parentScope.import('galaxy/router');
const inputs = Scope.import('galaxy/inputs');
const apiService = Scope.import('services/api.js');
const animations = Scope.import('services/animations.js');

Scope.data.member = null;

apiService.getMemberById(inputs.data.params.id).then(function (data) {
  Scope.data.member = data;
  Scope.data.form.member_id = data.id;
});

Scope.data.form = {
  member_id: null,
  start_time: null,
  end_time: null
};

view.init({
  tag: 'form',
  autocomplete: 'off',
  method: 'post',
  class: 'form',
  on: {
    submit: function (event) {
      event.preventDefault();
      apiService.addTimeOff(Scope.data.form).then(function (data) {
        console.info('Time off added successful', data);
        router.navigateFromHere('/');
      });
    }
  },
  animations: {
    enter: animations.formEnter,
    leave: animations.formLeave
  },
  children: [
    {
      tag: 'h2',
      text: 'Time off'
    },

    {
      tag: 'h3',
      text: '<>data.member.name'
    },

    {
      class: 'content',
      lifecycle: {
        postEnter: function () {
          jQuery('.datetimepicker').datetimepicker({
            onChangeDateTime: function (a, $input) {
              const node = $input[0];
              Scope.data.form[node.getAttribute('name')] = node.value;
            },
            closeOnDateSelect: true,
            format: 'Y-m-d H:i',
            allowTimes: [
              '7:00',
              '7:30',
              '8:00',
              '8:30',
              '9:00',
              '9:30',
              '10:00',
              '10:30',
              '11:00',
              '11:30',
              '12:00',
              '12:30',
              '13:00',
              '13:30',
              '14:00',
              '14:30',
              '15:00',
              '15:30',
              '16:00',
              '16:30',
              '17:00',
              '17:30',
              '18:00',
              '18:30'
            ]
          });
        }
      },

      children: [
        {
          tag: 'label',
          class: 'field',

          children: [
            {
              tag: 'span',
              text: 'From'
            },
            {
              tag: 'input',
              class: 'datetimepicker',
              name: 'start_time',
              required: 'true',
              placeholder: 'YYYY-MM-DD HH:MM',
              value: '<>data.form.start_time',

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
              text: 'Till'
            },
            {
              tag: 'input',
              class: 'datetimepicker',
              name: 'end_time',
              required: 'true',
              placeholder: 'YYYY-MM-DD HH:MM',
              value: '<>data.form.end_time'
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