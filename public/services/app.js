Scope.exports = {
  activeTeamId: null,
  allTeams: [],
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
  setAllTeams: function(teams) {
    this.allTeams = teams;

    if(this.activeTeamId) {
      this.setActiveTeamById(this.activeTeamId);
    }
  },
  setActiveTeamById: function (id) {
    this.activeTeamId = id;
    this.setActiveTeam(id, this.allTeams);
  },
  cycle: []
};