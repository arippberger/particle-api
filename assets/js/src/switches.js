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

            this.setState({
                switchOneStatus: result[Object.keys(result)[0]].status,
                switchTwoStatus: result[Object.keys(result)[1]].status,
                switchThreeStatus: result[Object.keys(result)[2]].status
            });

        }.bind(this));
    }

    componentWillUnmount() {
        this.serverRequest.abort();
    }


    onChange(event) {
        this.setState({status: event.target.checked});
        this.props.onChange(event);
    }

    render() {

        return (
            <div>
                <h2>Switch Status</h2>
                <ul>
                    <li><strong>Switch One Status:</strong> {this.state.switchOneStatus}</li>
                    <li><strong>Switch Two Status:</strong> {this.state.switchTwoStatus}</li>
                    <li><strong>Switch Three Status:</strong> {this.state.switchThreeStatus}</li>
                </ul>
            </div>
        );
    }

}
