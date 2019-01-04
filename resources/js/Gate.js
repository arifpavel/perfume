export default class Gate{
    constructor(user){
        this.user = user
    }
    isSuperAdmin(){
        return this.user.type === 'superadmin';
    }
    isAdmin(){
        return this.user.type === 'admin';
    }
    isUser(){
        return this.user.type === 'user';
    }
}