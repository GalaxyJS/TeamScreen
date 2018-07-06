const view = Scope.import('galaxy/view');

view.init({
  class: 'form',
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
        scale: .5,
        opacity: 0
      },
      duration: .2
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
              tag: 'input'
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
              tag: 'input'
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
              tag: 'select'
            }
          ]
        }
      ]
    }
  ]
});