Scope.exports = {
  get: function (url) {
    return fetch(url, {
      method: 'GET',
      mode: 'cors',
      credentials: 'same-origin',
      referrerPolicy: 'origin-when-cross-origin'
    }).then(function (response) {
      return response.json();
    }, function (error) {
      console.error('services/api.js', error);
    });
  },

  add: function (component, data) {
    return fetch('/api/' + component, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json; charset=utf-8'
      },
      body: JSON.stringify(data)
    }).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      throw error.json().then(function (content) {
        const errorText = JSON.stringify(content, null, ' ');
        console.error(errorText);
        alert(errorText);
      });
    });
  },
  update: function (component, data) {
    return fetch('/api/' + component, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json; charset=utf-8'
      },
      body: JSON.stringify(data)
    }).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  getActiveSprint: function (boardId) {
    return this.get('/api/board/' + boardId + '/active-sprint');
  },
  getAllBoards: function () {
    return this.get('/api/board/');
  },
  getBoardConfiguration: function (boardId) {
    return this.get('/api/board/' + boardId + '/configuration');
  },
  getSprintIssues: function (sprintId) {
    return this.get('/api/sprint/' + sprintId + '/issues');
  },

  addTeam: function (data) {
    return this.add('team', data);
  },
  addMember: function (data) {
    return this.add('member', data);
  },
  addTimeOff: function (data) {
    return this.add('agendas', data);
  },

  updateMember: function (data) {
    return this.update('member/' + data.id, data);
  },

  updateTeam: function (data) {
    return this.update('team/' + data.id, data);
  },

  getAllTeams: function () {
    return fetch('/api/team').then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },
  getAllMembers: function () {
    return fetch('/api/member').then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  getMemberById: function (id) {
    return fetch('/api/member/' + id).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  getTeamMembers: function (id) {
    return fetch('/api/member').then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  getTeamById: function (id) {
    return fetch('/api/team/' + id).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  deleteMember: function (id) {
    return fetch('/api/member/' + id, {
      method: 'DELETE'
    }).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  deleteTeam: function (id) {
    return fetch('/api/team/' + id, {
      method: 'DELETE'
    }).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  getAgendasForTeam: function (id) {
    return fetch('/api/team/' + id + '/agendas/').then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },

  deleteAgenda: function (id) {
    return fetch('/api/agendas/' + id, {
      method: 'DELETE'
    }).then(function (response) {
      if (response.status !== 200) {
        throw response;
      }

      return response.json();
    }).catch(function (error) {
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  }
};