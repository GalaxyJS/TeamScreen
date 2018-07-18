Scope.exports = {
  avatarURLGenerator: function (username) {
    return 'api/avatars/' + username + '/medium';
  },
  bigAvatarURLGenerator: function (username) {
    return 'api/avatars/' + username + '/xlarge';
  }
};

