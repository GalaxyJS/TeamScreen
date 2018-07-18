const view = Scope.import('galaxy/view');
const appService = Scope.import('services/app.js');
Scope.data.appService = appService;

const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');

Scope.data.waiter = null;

let randomInterval;

function selectRandomWaiter(members) {
  if (members && appService.cycle.length === members.length) {
    appService.cycle = [];
  }

  if (members && members.length) {
    let randomIndex = Math.floor(Math.random() * members.length);
    let randomWaiter = members[randomIndex];
    while (appService.cycle.indexOf(randomWaiter.id) !== -1) {
      randomIndex = Math.floor(Math.random() * members.length);
      randomWaiter = members[randomIndex];
    }

    appService.cycle.push(randomWaiter.id);
    Scope.data.waiter = randomWaiter;
  }
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

  randomWaiterInterval: [
    'data.appService.activeMembers',
    function (members) {
      Scope.data.waiter = null;
      selectRandomWaiter(members);
      clearInterval(randomInterval);
      randomInterval = setInterval(function () {
        selectRandomWaiter(members);
      }, (60 * 1000) * 120);

      return '';
    }
  ],

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
              'data.appService.cycle',
              function (memberId, ac) {
                const result = ['person-item'];

                if (ac.indexOf(memberId) !== -1) {
                  result.push('disable');
                }

                return result;
              }
            ],

            $for: {
              data: '<>data.appService.activeMembers.changes',
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