Scope.exports = {

  avatarURL: {
    x48: function (username) {
      if (username) {
        return 'api/avatars/' + username + '/48X48';
      }

      return null;
    },
    medium: function (username) {
      if (username) {
        return 'api/avatars/' + username + '/medium';
      }

      return null;
    },
    big: function (username) {
      if (username) {
        return 'api/avatars/' + username + '/xlarge';
      }

      return null;
    },
  }
};

