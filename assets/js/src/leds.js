import React from "react";
var $ = require('jquery');

export default class SwitchStatus extends React.Component {

    constructor() {
        super();

        this.timerFrequency = 5000;

        this.state = {
            redLEDStatus: false,
            greenLEDStatus: false
        };

        this.makeCheckedLink = this.makeCheckedLink.bind(this);
        this.updateLEDStatus = this.updateLEDStatus.bind(this);

    }

    checkAndUpdateLEDs() {
        setInterval( function() {
            this.serverRequest = $.get('http://particle-api.alecrippberger.com/wp-json/particle-api/v1/light', function (result) {

                console.log(result);

                this.setState({
                    redLEDStatus: (result[Object.keys(result)[0]].status == 'true'),
                    greenLEDStatus: (result[Object.keys(result)[1]].status == 'true')
                });

            }.bind(this))}.bind(this), this.timerFrequency);
    }

    componentDidMount() {

        console.log('LEDs component did mount');

        this.checkAndUpdateLEDs();

    }

    componentWillUnmount() {
        this.serverRequest.abort();
    }

    makeCheckedLink(key) {

        return {
            value: this.state[key],
            requestChange: function (newValue) {
                var newState = {};
                newState[key] = newValue;
                this.state = newState;
            }
        }
    }

    updateLEDStatus(e) {
        var color = e.target.dataset.color;

        //console.log(this.state[ color + 'LEDStatus']);

        $.ajax({
            url: 'http://particle-api.alecrippberger.com/wp-json/particle-api/v1/light/' + color,
            //url: 'http://wpapi.dev/wp-json/particle-api/v1/light/' + color,
            type: 'post',
            data: JSON.stringify({
                "status": e.target.checked
            }),
            headers: {
                //Authorization: 'Basic YWRtaW46cGFzc3dvcmQ=' //not real - local
                //Authorization: 'Basic YWxlYzpLNmZGIG1QcGsgSWVscyBQc1ph' //accidentally published - now revoked :-)
                Authorization: 'Basic ce89e5263edefbaf67ec44e1eb83b5e1'
            },
            dataType: 'json',
            success: function (data) {
                console.log('success');
                console.log(data);
            },
            complete: function (data) {
                console.log('complete');
                console.log(data);
            }
        });
    }

    render() {

        return (
            <div>
                <h2>LED Status</h2>
                <ul>
                    <li><label htmlFor="red-led-on"><strong>Red LED Status: </strong>
                        <input type="checkbox" checkedLink={this.makeCheckedLink('redLEDStatus')}
                               onClick={this.updateLEDStatus} data-color="red"/>
                    </label>
                    </li>
                    <li><label htmlFor="green-led-on"><strong>Green LED Status: </strong>
                        <input type="checkbox" checkedLink={this.makeCheckedLink('greenLEDStatus')}
                               onClick={this.updateLEDStatus} data-color="green"/>
                    </label>
                    </li>
                </ul>
            </div>
        );
    }
}
