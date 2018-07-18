Scope.exports = {
  widgetEnter: {
    parent: 'widgets-leave-sequence',
    sequence: 'widgets-enter-and-leave-sequence',
    from: {
      scale: .86,
      opacity: 0,
      clearProps: 'all'
    },
    position: '-=.2',
    duration: .4
  },
  widgetLeave: {
    sequence: 'widgets-leave-sequence',
    to: {
      scale: .8,
      opacity: 0,
      display: 'none'
    },
    position: '-=.2',
    duration: .3
  },
  formEnter: {
    sequence: 'overlay-form',
    from: {
      scale: .8,
      opacity: 0
    },
    duration: .3
  },
  formLeave: {
    sequence: 'overlay-form',
    to: {
      y: -50,
      opacity: 0,
      display: 'none'
    },
    duration: .3
  }
};

