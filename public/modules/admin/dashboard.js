/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const router = Scope.import('galaxy/router');

const apiService = Scope.import('services/api.js');
const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');
const appService = Scope.import('services/app.js');

const rowEnterAnimation = {
  parent: animations.widgetEnter.sequence,
  sequence: 'row-animation',
  from: {
    y: -15,
    opacity: 0
  },
  to: {
    y: 0,
    opacity: 1
  },
  position: '-=.15',
  duration: .2
};

const rowLeaveAnimation = {
  sequence: 'row-leave',
  to: {
    scale: .9,
    opacity: 0
  },
  duration: .2
};

Scope.data.routes = [
  {
    id: 'new-member',
    module: {
      url: 'modules/admin/member-form.js'
    }
  }
];
Scope.data.activeModule = null;
Scope.data.activeModuleData = {
  params: null
};
Scope.data.activeModuleInputs = {
  busy: false,
  data: '<>data.activeModuleData'
};

Scope.data.teams = [];
Scope.data.members = [];

function fetchMembers() {
  apiService.getAllMembers().then(function (members) {
    // setTimeout(function () {
      Scope.data.members = members;
    // }, 800)

  });
}

function fetchTeams() {
  apiService.getAllTeams().then(function (teams) {
    Scope.data.teams = teams;

    if (appService.activeTeam) {
      appService.setActiveTeam(appService.activeTeam.id, teams);
    }
  });
}

function fetchAllData() {
  fetchTeams();
  fetchMembers();
}

router.init({
  '/': function () {
    Scope.data.activeModule = null;

    fetchAllData();
  },
  '/new-member': function () {
    Scope.data.activeModuleData.params = null;
    Scope.data.activeModule = {
      url: 'modules/admin/member-form.js'
    };
  },
  '/edit-member/:id': function (params) {
    Scope.data.activeModuleData.params = params;
    Scope.data.activeModule = {
      url: 'modules/admin/member-form.js'
    };
  },

  '/new-team': function () {
    Scope.data.activeModuleData.params = null;
    Scope.data.activeModule = {
      url: 'modules/admin/team-form.js'
    };
  },
  '/edit-team/:id': function (params) {
    Scope.data.activeModuleData.params = params;
    Scope.data.activeModule = {
      url: 'modules/admin/team-form.js'
    };
  },

  '/time-off/:id': function (params) {
    Scope.data.activeModuleData.params = params;
    Scope.data.activeModule = {
      url: 'modules/admin/time-off-form.js'
    };
  }
});

view.init([
  {
    class: 'container-row',
    children: [
      {
        animations: {
          enter: animations.widgetEnter
          // leave: animations.widgetLeave
        },

        class: 'widget width-75',
        children: [
          {
            tag: 'h2',
            text: 'Members'
          },
          {
            class: 'content',
            children: [
              {
                tag: 'button',
                text: 'New Member',

                on: {
                  click: function () {
                    router.navigateFromHere('new-member');
                  }
                }
              }
            ]
          },
          {
            class: {
              'content': true,
              'container-row': true,
              'loaded': [
                'data.members.length',
                function (length) {
                  return length > 0;
                }
              ]
            },
            animations: {
              '.loaded': Object.assign({},
                animations.cascadeAnimation,
                {
                  sequence: 'members',
                  parent: animations.widgetEnter.sequence
                })
            },
            children: [
              {
                tag: 'table',
                children: [
                  {
                    tag: 'tr',
                    children: [
                      {
                        tag: 'th',
                        text: 'Avatar'
                      },
                      {
                        tag: 'th',
                        text: 'Name'
                      },
                      {
                        tag: 'th',
                        text: 'JIRA Username'
                      },
                      {
                        tag: 'th',
                        text: 'Team'
                      },
                      {
                        tag: 'th',
                        text: ''
                      }
                    ]
                  },
                  {
                    tag: 'tr',

                    animations: {
                      config: {
                        leaveWithParent: true,
                        enterWithParent: true
                      },
                      // enter: {
                      //   sequence: rowLeaveAnimation.sequence,
                      //   from: {
                      //     scale: .8,
                      //     opacity: 0
                      //   },
                      //   duration: 1.2
                      // },
                      leave: rowLeaveAnimation
                    },

                    $for: {
                      data: '<>data.members.changes',
                      as: 'member',
                      trackBy: function (item) {
                        return item.updated_at;
                      }
                    },

                    children: [
                      {
                        tag: 'td',
                        children: {
                          tag: 'img',
                          class: 'avatar',
                          src: [
                            'member.username',
                            utility.avatarURLGenerator
                          ]
                        }
                      },
                      {
                        tag: 'td',
                        text: '<>member.name'
                      },
                      {
                        tag: 'td',
                        class: 'text-bold',
                        text: '<>member.username'
                      },
                      {
                        tag: 'td',
                        text: '<>member.team.name'
                      },

                      {
                        tag: 'td',
                        inputs: {
                          member: '<>member'
                        },
                        children: [
                          {
                            tag: 'button',

                            on: {
                              click: function () {
                                router.navigateFromHere('/time-off/' + this.parent.inputs.member.id);
                              }
                            },

                            children: {
                              tag: 'i',
                              class: 'fas fa-calendar-plus'
                            }
                          },
                          {
                            tag: 'button',
                            on: {
                              click: function () {
                                router.navigateFromHere('/edit-member/' + this.parent.inputs.member.id);
                              }
                            },

                            children: {
                              tag: 'i',
                              class: 'fas fa-edit'
                            }
                          },
                          {
                            tag: 'button',
                            on: {
                              click: function () {
                                if (confirm('Are you sure of deleting of this member?')) {
                                  apiService.deleteMember(this.parent.inputs.member.id).then(function () {
                                    fetchMembers();
                                  });
                                }
                              }
                            },

                            children: {
                              tag: 'i',
                              class: 'fas fa-trash-alt'
                            }
                          }
                        ]
                      }
                    ]
                  }
                ]
              }
            ]
          }
        ]
      },
      {
        animations: {
          enter: animations.widgetEnter
          // leave: animations.widgetLeave
        },

        class: 'widget width-s',
        children: [
          {
            tag: 'h2',
            text: 'Teams'
          },
          {
            class: 'content',
            children: {
              tag: 'button',
              text: 'New Team',

              on: {
                click: function () {
                  router.navigateFromHere('new-team');
                }
              }
            }
          },
          {
            class: 'content',
            children: [
              {
                tag: 'table',
                children: {
                  tag: 'tr',

                  animations: {
                    config: {
                      leaveWithParent: true
                    },
                    enter: Object.assign({}, rowEnterAnimation, { sequence: 'teams' }),
                    leave: rowLeaveAnimation
                  },

                  $for: {
                    data: '<>data.teams.changes',
                    as: 'team',
                    trackBy: function (item) {
                      return item.id;
                    }
                  },

                  children: [
                    {
                      tag: 'td',
                      text: '<>team.name'
                    },
                    {
                      tag: 'td',
                      inputs: {
                        teamId: '<>team.id'
                      },

                      children: [
                        {
                          tag: 'button',
                          on: {
                            click: function () {
                              router.navigateFromHere('/edit-team/' + this.parent.inputs.teamId);
                            }
                          },

                          children: {
                            tag: 'i',
                            class: 'fas fa-edit'
                          }
                        },
                        {
                          tag: 'button',
                          children: {
                            tag: 'i',
                            class: 'fas fa-trash-alt'
                          },

                          on: {
                            click: function () {
                              if (confirm('Are you sure of deleting of this team?')) {
                                apiService.deleteTeam(this.parent.inputs.teamId).then(function () {
                                  fetchTeams();
                                });
                              }
                            }
                          }
                        }
                      ]
                    }
                  ]
                }
              }
            ]
          }
        ]
      }
    ]
  },
  {
    class: 'overlay',
    $if: '<>data.activeModule',
    animations: {
      enter: {
        from: {
          opacity: 0
        },
        duration: .3
      },
      leave: {
        to: {
          opacity: 0
        },
        duration: .2
      }
    },

    on: {
      keydown: function (event) {
        if (event.keyCode === 27) {
          router.navigateFromHere('/');
        }
      },
      click: function (event) {
        if (this.node === event.target) {
          router.navigateFromHere('/');
        }
      }
    },

    inputs: Scope.data.activeModuleInputs,
    module: '<>data.activeModule',
    children: {}
  }
]);