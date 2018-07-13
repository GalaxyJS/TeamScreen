Scope.exports = {
  avatarURLGenerator: function (username) {
    return 'https://jira.local.mybit.nl/secure/useravatar?size=medium&ownerId=' + username;
  },
  bigAvatarURLGenerator: function (username) {
    return 'https://jira.local.mybit.nl/secure/useravatar?size=xlarge&ownerId=' + username;
  }
};

