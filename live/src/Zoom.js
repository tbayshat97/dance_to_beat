import "./Zoom.css";
import { ZoomMtg } from "@zoomus/websdk";
import { useEffect } from "react";

const crypto = require("crypto"); // crypto comes with Node.js

function generateSignature(apiKey, apiSecret, meetingNumber, role) {
    return new Promise((res, rej) => {
        // Prevent time sync issue between client signature generation and zoom
        const timestamp = new Date().getTime() - 30000;
        const msg = Buffer.from(apiKey + meetingNumber + timestamp + role).toString(
            "base64"
        );
        const hash = crypto
            .createHmac("sha256", apiSecret)
            .update(msg)
            .digest("base64");
        const signature = Buffer.from(
            `${apiKey}.${meetingNumber}.${timestamp}.${role}.${hash}`
        ).toString("base64");

        res(signature);
    });
}

var apiKey = "wybHZLZeShO8EBPvxetTIA";
var apiSecret = "vYxkOfBPlaM1K6DuphKCOlN8w8QKpzQxKpFI";
var meetingNumber = 93781494247;
var leaveUrl = "http://localhost:3000"; // our redirect url
var userName = "Tubishat97";
var userEmail = "kareem@qiotic.com";
var passWord = "12345678";

var signature = "";
generateSignature(apiKey, apiSecret, meetingNumber, 1).then((res) => {
    signature = res;
}); // need to generate based on meeting id - using - role by default 0 = javascript

const Zoom = () => {
    // loading zoom libraries before joining on component did mount
    useEffect(() => {
        showZoomDIv();
        ZoomMtg.setZoomJSLib("https://source.zoom.us/1.9.0/lib", "/av");
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareJssdk();
        initiateMeeting();
    }, []);

    const showZoomDIv = () => {
        document.getElementById("zmmtg-root").style.display = "block";
    };

    const initiateMeeting = () => {
        ZoomMtg.init({
            leaveUrl: leaveUrl,
            isSupportAV: true,
            success: (success) => {
                ZoomMtg.join({
                    signature: signature,
                    meetingNumber: meetingNumber,
                    userName: userName,
                    apiKey: apiKey,
                    userEmail: userEmail,
                    passWord: passWord,
                    success: (success) => {
                        console.log(success);
                    },
                    error: (error) => {
                        console.log(error);
                    },
                });
            },
            error: (error) => {
                console.log(error);
            },
        });
    };

    return <div className="App">Zoom</div>;
};

export default Zoom;
