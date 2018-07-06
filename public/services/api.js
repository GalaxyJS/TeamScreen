const config = Scope.import('config.js');

Scope.exports = {
  apiURL: config.apiURL,
  getAllBoards: function () {
    return fetch(this.apiURL + '/api.js/boards/', {
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
    return fetch(this.apiURL + '/api.js/boards/' + boardId + '/configuration', {
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
  getSprintIssues: function ( sprintId) {
    return fetch(this.apiURL + '/api.js/sprints/' + sprintId + '/issues', {
      method: 'GET',
      mode: 'cors',
      credentials: 'same-origin',
      referrerPolicy: 'origin-when-cross-origin'
    }).then(function (response) {
      return response.json();
    }, function (error) {
      console.error('services/api.js', error);
    });
  }
};