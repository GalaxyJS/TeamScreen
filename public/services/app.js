Scope.exports = {
  activeTeam: null,
  activeMembers: null,
  setActiveTeam: function (teamId, teams) {
    const activeTeam = teams.find(function (item) {
      return item.id === parseInt(teamId);
    });

    this.activeTeam = activeTeam;
    this.activeMembers = activeTeam.members;
  }
};