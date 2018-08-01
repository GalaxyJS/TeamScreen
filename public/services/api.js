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

  getActiveSprint: function (boardId) {
    return this.get('/api/board/' + boardId + '/active-sprint');
  },
  getAllBoards: function () {
    return this.get('/api/board/');
  },
  getBoardConfiguration: function (boardId) {
    return fetch('/api/board/' + boardId + '/configuration', {
      method: 'GET', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, cors, *same-origin
      // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, same-origin, *omit
      referrerPolicy: 'origin-when-cross-origin'
      // headers: {
      //   'Content-Type': 'application/json; charset=utf-8',
      //   // 'Content-Type': 'application/x-www-form-urlencoded',
      // }
    }).then(function (response) {
      return response.json();
    }, function (error) {
      console.error('services/api.js', error);
    });
  },
  getSprintIssues: function (sprintId) {
    return fetch('/api/sprint/' + sprintId + '/issues', {
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
  }
};