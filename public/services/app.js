Scope.exports = {
  activeTeam: null,
  activeMembers: null,
  setActiveTeam: function (teamId, teams) {
    const activeTeam = teams.find(function (item) {
      return item.id === parseInt(teamId);
    });

    if (!this.activeTeam || this.activeTeam.id !== activeTeam.id) {
      this.cycle = [];
    }

    this.activeTeam = activeTeam;
    this.activeMembers = activeTeam ? activeTeam.members : [];
  },
  cycle: []
};