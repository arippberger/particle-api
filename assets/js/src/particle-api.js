import React from "react";
import ReactDOM from "react-dom";
import SwitchStatus from "./switches.js";
import LEDStatus from "./leds.js";

class ParticleAPI extends React.Component {
    render() {
        return (
            <div>
                <SwitchStatus />
                <LEDStatus />
            </div>
        );
    }
}

ReactDOM.render(
    <ParticleAPI />,
    document.getElementById('particle-api-shortcode')
);