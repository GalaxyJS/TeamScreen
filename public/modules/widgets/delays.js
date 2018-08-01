const view = Scope.import('galaxy/view');
const inputs = Scope.import('galaxy/inputs');

const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');

const googleMapService = new google.maps.DistanceMatrixService();

const origin = ['1217 ZC Hilversum, Netherlands'];

function getTrafficInformation(destination) {
  if (!googleMapService) {
    return Promise.resolve('NOT_READY');
  }

  const param = {
    origins: origin,
    destinations: [destination],
    travelMode: 'DRIVING', //Default is DRIVING; for other modes, a paid Premium Google API is needed.
    drivingOptions: {
      departureTime: new Date()
    }
  };

  return new Promise(function (resolved, reject) {
    googleMapService.getDistanceMatrix(param, function (response) {
      try {
        const result = response.rows[0].elements[0];
        if (result.status !== 'NOT_FOUND') {
          const diff = result.duration_in_traffic.value - result.duration.value;
          const diffInMinutes = Math.round(diff / 60);
          resolved(diffInMinutes || 0);
        } else {
          resolved(0);
        }
      } catch (exception) {
        reject('ERROR');
      }
    });
  });
}

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
              enter: Object.assign({}, animations.itemEnter, {
                parent: animations.widgetEnter.sequence,
                sequence: 'delays'
              })
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
                      member.delay = 'LOADING';
                      if (member.destination) {
                        getTrafficInformation(member.destination).then(function (time) {
                          if (time === 'NOT_READY') {
                            setTimeout(update, 100);
                          } else {
                            member.delay = time;
                          }
                        });
                      } else {
                        member.delay = 'NO_ADDRESS';
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

                        if (delay === 'ERROR') {
                          return 'fas fa-exclamation-circle c-red';
                        }

                        if (delay === 'LOADING') {
                          return 'fas fa-spinner';
                        }

                        if (delay === 'NO_ADDRESS') {
                          return 'fas fa-map-marked-alt';
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

                        if (delay === 'ERROR') {
                          return 'ERROR';
                        }

                        if (delay === 'NO_ADDRESS') {
                          return '';
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
    }
  ]
});
