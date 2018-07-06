/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const router = Scope.import('galaxy/router');
const apiService = Scope.import('services/api.js');

Scope.data.routes = [
  {
    id: 'new-member',
    module: {
      url: 'modules/admin/new-member.js'
    }
  }
];
Scope.data.activeModule = null;

router.init({
  '/': function () {
    Scope.data.activeModule = null;
  },
  '/new-member': function () {
    Scope.data.activeModule = {
      url: 'modules/admin/new-member.js'
    };
  }
});
console.log(Scope);
view.init([
  {
    class: 'container-row',
    children: [
      {
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
            class: 'content container-row',
            children: [
              // {
              //   class: 'toggle-group',
              //   children: [
              //     {
              //       tag: 'label',
              //       children: [
              //         {
              //           tag: 'input',
              //           name: 'page',
              //           type: 'radio',
              //           value: 'members'
              //         },
              //         {
              //           tag: 'span',
              //           text: 'Members'
              //         }
              //
              //       ]
              //     },
              //     {
              //       tag: 'label',
              //       children: [
              //         {
              //           tag: 'input',
              //           name: 'page',
              //           type: 'radio',
              //           value: 'groups'
              //         },
              //         {
              //           tag: 'span',
              //           text: 'Groups'
              //         }
              //       ]
              //     }
              //   ]
              // }
            ]
          }
        ]
      },
      {
        class: 'widget width-25',
        children: [
          {
            tag: 'h2',
            text: 'Groups'
          },
          {
            class: 'content',
            children: {
              tag: 'button',
              text: 'New Group'
            }
          },
          {
            class: 'content'

          }
        ]
      }
    ]
  },
  {
    class: 'overlay',
    $if: '<>data.activeModule',
    // animations: {
    //   leave: {
    //     duration: .3
    //   }
    // },
    // children: {
      module: '<>data.activeModule'
    // }
  }
]);