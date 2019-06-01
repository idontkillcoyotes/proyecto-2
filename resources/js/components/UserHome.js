import React , { Component } from 'react'

import UserAvatars from './UserAvatars'
import AvatarEditor from '.Avatars/AvatarEditor'

class UserHome extends Component {

    constructor(props){
        super(props);
        this.state={
            user: null,
            status: null,
            isLoaded: false,
            error: false,
        }
        console.log("USERHOME: constructor");
        console.log(super(props));
    }

    fetchUser(){
        const bearer = 'Bearer ' + this.props.api_token;
        console.log("USERHOME: Fetching user");
        fetch('/api/user', { 
            method: 'GET',
            headers: {
                'Authorization': bearer, 
                'Accept': 'application/json'  
            }
        })
        .then( 
            (response) => {
                console.log("USERHOME: obtuve respuesta");
                return response.json();
            }
        )
        .then(
            (result) => {
                console.log("USERHOME: finalizo fetching user");
                if (result.message){
                    this.setState({
                        isLoaded: true,
                        error: true,
                        status: result.message,
                    });
                }
                else{
                    this.setState({
                        isLoaded: true,
                        user: result,
                    });
                }
            }
        )
    }

    componentDidMount(){
        this.fetchUser();
    }

    renderApp(){
        const {error, isLoaded} = this.state;
        if (isLoaded){
            if (error){
                return(
                    <div className="row justify-content-center">
                        <div className="col-md-4">
                            Error: {this.state.status}
                        </div>
                    </div>
                );
            }
            else{
                return(
                    <div className="row justify-content-center">    
                        <div className="col-md-4 testing">
                            <UserAvatars 
                                api_token={this.props.api_token}
                                user={this.state.user}
                            />
                        </div>
                        <div className="col-md-8 testing">
                            <AvatarEditor

                            />
                        </div>                                            
                    </div>
                );
            }            
        }
        else {
            return(
                <div className="row justify-content-center">                
                    <div className="col-md-3 testing">
                        <span>
                            Cargando datos de usuario 
                            <i className="fa fa-spinner fa-spin loading"></i>
                        </span>
                    </div>
                    <div className="col-md-9 testing">
                    </div>
                </div>
            );
        }

    }

    render(){
        return(
            <div className="container testing">                
                {this.renderApp()}
            </div>
        );
    }


}

export default UserHome;