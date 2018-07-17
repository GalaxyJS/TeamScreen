const view = Scope.import('galaxy/view');
const inputs = Scope.import('galaxy/inputs');

const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');

Scope.data.waiter = null;
Scope.data.cycle = [];

function selectARandomWaiter() {
  setInterval(function () {
    if (inputs.members && Scope.data.cycle.length === inputs.members.length) {
      Scope.data.cycle = [];
    }

    if (inputs.members && inputs.members.length) {
      let randomIndex = Math.floor(Math.random() * inputs.members.length);
      let randomWaiter = inputs.members[randomIndex];
      while (Scope.data.cycle.indexOf(randomWaiter.id) !== -1) {
        randomIndex = Math.floor(Math.random() * inputs.members.length);
        randomWaiter = inputs.members[randomIndex];
      }

      Scope.data.cycle.push(randomWaiter.id);
      Scope.data.waiter = randomWaiter;
    }
  }, 3000);
}

const memberEnterAnimation = {
  parent: animations.widgetEnter.sequence,
  sequence: 'time-for-drink',
  from: {
    height: 0,
    paddingTop: 0,
    paddingBottom: 0
  },
  position: '-=.1',
  duration: .2
};

view.init({
  animations: {
    enter: animations.widgetEnter,
    leave: animations.widgetLeave
  },

  lifecycle: {
    postInsert: function () {
      selectARandomWaiter();
    }
  },

  class: 'container-row',
  children: {
    class: 'widget width-full time-for-drink',
    children: [
      {
        tag: 'h2',
        text: 'Time for Drink'
      },
      {
        class: 'content',
        children: [
          {
            tag: 'p',
            class: 'person-item spotlight',
            children: [
              {
                tag: 'img',
                class: 'avatar',
                src: [
                  'data.waiter.username',
                  utility.bigAvatarURLGenerator
                ]
              },
              {
                tag: 'span',
                html: [
                  'data.waiter.name',
                  function (name) {
                    return '<strong>' + name + '</strong>, it\'s your turn to bring us the drinks!';
                  }
                ]
              }
            ]
          },
          {
            animations: {
              enter: memberEnterAnimation
            },

            tag: 'p',
            class: [
               'member.id',
              'data.cycle',
              function (memberId, ac) {
                const result = ['person-item'];

                if (ac.indexOf(memberId) !== -1) {
                  result.push('disable');
                }

                return result;
              }
            ],
          // {
          //   'person-item': true,
          //   disable: [
          //     'member.id',
          //     'data.cycle',
          //     function (memberId, ac) {
          //       // const result = ['person-item'];
          //
          //       if (ac.indexOf(memberId) !== -1) {
          //         return true;
          //       }
          //
          //       return false
          //     }
          //   ]
          // }
            $for: {
              data: [
                '<>inputs.members.changes',
                function (changes) {
                  return changes;
                }
              ],
              as: 'member'
            },
            children: [
              {
                tag: 'img',
                class: 'avatar',
                src: [
                  'member.username',
                  utility.avatarURLGenerator
                ]
              },
              {
                tag: 'strong',
                text: '<>member.name'
              },
              {
                class: 'content',

                inputs: {
                  member: '<>member'
                },
                text: '<>member.drink_preference'
              }
            ]
          }
        ]
      }
    ]
  }
});