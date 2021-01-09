import Storage from './Storage.js'
import Token from './Token.js'
import Exception from './Exception.js'



class User {
    login(data)
    {
        axios.post('/api/login',data)
        .then((response) => {
            this.responseAfterLogin(response)
        }).catch((err) => {
            console.log(err.response.data);
        });
    }

    logout()
    {
        const data = {
            token : Storage.getToken()
        }

        if(Token.isValid(data.token))
        {
            axios.get('/api/logout',{params : data})
            .then((response) => {
                this.clear()

            }).catch((err) => {
                Exception.handle(err);
                console.log(err.response.data)
            });
        }

    }
    clear()
    {
        Storage.clear();
        window.location = '/forum'
    }


    responseAfterLogin(response) {

        const token = response.data.token;
        const username = response.data.user;

        if(Token.isValid(token))
        {
            Storage.store(username,token);
            window.location = '/forum'
        }

    }

    hasToken() {

        const storedToken = Storage.getToken();

        if(storedToken) {

            return Token.isValid(storedToken) ? true : this.clear();
        }
        return false;
    }

    loggedIn()
    {
        return this.hasToken();
    }


    name()
    {
        if(this.loggedIn()){
            return Storage.getUser();
        }
    }

    id()
    {
        if(this.loggedIn())
        {
            return Token.payload(Storage.getToken()).sub;
        }
    }

    ownQuestion(id) {
        return this.id() === id;
    }

    admin()
    {
        return this.id() === 1;
    }


    ownReply(id)
    {
        return this.id() === id;
    }

}
export default User = new User();
