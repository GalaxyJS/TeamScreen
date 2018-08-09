Scope.exports = {
  avatarURLGenerator: function (username) {
    if (username) {
      return 'api/avatars/' + username + '/medium';
    }

    return null;
  },
  bigAvatarURLGenerator: function (username) {
    if (username) {
      return 'api/avatars/' + username + '/xlarge';
    }

    return null;
  }
};

