const view = Scope.import('galaxy/view');
const inputs = Scope.import('galaxy/inputs');

const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');

let googleMapService;

const origin = ['1217 ZC Hilversum, Netherlands'];

function getTrafficInformation(destination) {
  if (!googleMapService) {
    return Promise.resolve('not_ready');
  }

  const param = {
    origins: origin,
    destinations: [destination],
    travelMode: 'DRIVING', //Default is DRIVING; for other modes, a paid Premium Google API is needed.
    drivingOptions: {
      departureTime: new Date()
    }
  };

  return new Promise(function (resolved) {
    googleMapService.getDistanceMatrix(param, function (response, reject) {
      try {
        const result = response.rows[0].elements[0];
        if (result.status !== 'NOT_FOUND') {
          const diff = result.duration_in_traffic.value - result.duration.value;
          const diffInMinutes = Math.round(diff / 60);
          resolved(diffInMinutes || 0)
        } else {
          resolved(0);
        }
      } catch (exception) {
        reject('error');
      }
    });
  });
}

const memberEnterAnimation = {
  parent: animations.widgetEnter.sequence,
  sequence: 'delay-list',
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

  class: 'container-row',
  children: [
    {
      class: 'widget width-full',
      children: [
        {
          tag: 'h2',
          text: 'Delays'
        },
        {
          class: 'content',
          children: {
            tag: 'p',
            class: 'person-item',

            animations: {
              enter: memberEnterAnimation
            },

            $for: {
              data: '<>inputs.members.changes',
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

                lifecycle: {
                  postInsert: function () {
                    const member = this.inputs.member;
                    const update = function () {
                      member.delay = 'loading';
                      if (member.destination) {
                        getTrafficInformation(member.destination).then(function (time) {
                          if (time === 'not_ready') {
                            setTimeout(update, 100);
                          } else {
                            member.delay = time;
                          }
                        });
                      }
                    };

                    update();
                    this.updateInterval = setInterval(update, (5 * 60 * 1000));
                  },
                  postRemove: function () {
                    clearInterval(this.updateInterval);
                  }
                },

                children: [
                  {
                    tag: 'i',
                    class: [
                      'member.delay',
                      function (delay) {
                        if (delay > 15) {
                          return 'far fa-angry c-red';
                        }

                        if (delay <= 15 && delay > 5) {
                          return 'far fa-meh c-orange';
                        }

                        if (delay === 'error') {
                          return 'fas fa-exclamation-circle c-red'
                        }

                        if (delay === 'loading') {
                          return 'fas fa-spinner'
                        }

                        return 'far fa-smile c-green';
                      }
                    ]
                  },
                  {
                    tag: 'span',
                    text: [
                      'member.delay',
                      function (delay) {
                        if (delay > 15) {
                          return '> 15 mins';
                        }

                        if (delay <= 15 && delay > 5) {
                          return '5-15 mins';
                        }

                        if (delay === 'error') {
                          return 'ERROR'
                        }

                        return '< 5 mins';
                      }
                    ]
                  }
                ]
              }
            ]
          }
        }
      ]
    },
    {
      tag: 'script',
      src: 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA4Nr1bQijl7QINVIwC7JCq7Ljh2FYk_8I',
      on: {
        load: function () {
          googleMapService = new google.maps.DistanceMatrixService();
        }
      }
    }
  ]
});