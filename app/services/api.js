Scope.exports = {
  getActiveSprint: function (boardId) {
    return fetch('https://jira.local.mybit.nl/rest/agile/1.0/board/'+boardId+'/sprint?state=active',{
      method: "GET", // *GET, POST, PUT, DELETE, etc.
      mode: "cors", // no-cors, cors, *same-origin
      // cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
      credentials: "same-origin", // include, same-origin, *omit
      referrerPolicy: 'origin-when-cross-origin'
      // headers: {
      //   "Content-Type": "application/json; charset=utf-8",
      //   // "Content-Type": "application/x-www-form-urlencoded",
      // }
    });
  }
};