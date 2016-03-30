import React from "react";
var $ = require('jquery');

export default class SwitchStatus extends React.Component{

    constructor(props) {
        super(props);
        this.state = {
            switchOneStatus: '',
            switchTwoStatus: '',
            switchThreeStatus: ''
        }
    }

    componentDidMount() {
        this.serverRequest = $.get('http://particle-api.alecrippberger.com/wp-json/particle-api/v1/switch', function (result) {
            console.log('result:');
            console.log(result);

            this.setState({
                switchOneStatus: '',
                switchTwoStatus: '',
                switchThreeStatus: ''
            });
        }.bind(this));
    }

    componentWillUnmount() {
        this.serverRequest.abort();
    }

    render() {
        return (
            <div>
                <h2>Switch Status</h2>
            </div>
        );
    }

}
