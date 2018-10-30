Scope.exports = {
  widgetEnter: {
    sequence: 'widgets-enter-and-leave-sequence',
    from: {
      scale: .86,
      opacity: 0,
      clearProps: 'all'
    },
    position: '-=.1',
    duration: .3
  },
  widgetLeave: {
    sequence: 'widgets-enter-and-leave-sequence',
    from: {
      width: function (w, node) {
        return node.offsetWidth;
      },
      position: 'absolute'
    },
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
      display: 'none',
      clearProps: 'all'
    },
    duration: .3
  },

  itemEnter: {
    sequence: 'item-animation',
    from: {
      height: 0,
      paddingTop: 0,
      paddingBottom: 0
    },
    position: '-=.05',
    duration: .15
  },

  cascadeAnimation: {
    sequence: 'cascade-animation',
    from: {
      height: function (v, node) {
        const height = node.offsetHeight;
        node._initOffsetHeight = height;
        return height;
      }
    },
    to: {
      height: function (v, node) {
        node.style.height = 'auto';
        const height = node.offsetHeight;
        node.style.height = node._initOffsetHeight + 'px' || 0;

        return height;
      }
    },
    position: '-=.15',
    duration: .5
  }
};

