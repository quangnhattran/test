let user = window.App.user;

module.exports = {
    owns(model, prop='user_id') {
        console.log(model[prop]);
        return model[prop] == user.id;
    },
    isAdmin() {
        return ['QT','Admin'].includes(user.name);
    }
}