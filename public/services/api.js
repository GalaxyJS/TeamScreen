const config = Scope.import('config.js');

Scope.exports = {
  apiURL: config.apiURL,
  getAllBoards: function () {
    return fetch(this.apiURL + '/api/boards/', {
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
  getBoardConfiguration: function (boardId) {
    return fetch(this.apiURL + '/api/boards/' + boardId + '/configuration', {
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
    return fetch(this.apiURL + '/api/sprints/' + sprintId + '/issues', {
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
  saveMember: function (data) {
    return fetch('/api/members', {
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
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },
  getAllTeams: function () {
    return fetch('/api/teams').then(function (response) {
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
    return fetch('/api/members').then(function (response) {
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
    return fetch('/api/members/' + id, {
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

  saveTeam: function (data) {
    return fetch('/api/teams', {
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
      console.error(error);
      error.json().then(function (content) {
        console.error(JSON.stringify(content, null, ' '));
      });
    });
  },
  deleteTeam: function (id) {
    return fetch('/api/teams/' + id, {
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