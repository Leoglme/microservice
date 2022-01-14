import React from 'react';
import Message from "./Message";
import {userConnected} from "../../common/data";


function Messages({currentChat}) {

    const messages = currentChat.messages;
    const userIsSender = (message) => {
        return userConnected.id === message.sender.id;
    }

    const oldMessage = (index) => {
        if (!index) return null;
        return messages[index - 1]
    }


    const List = (
        messages.map((message, index) => {
            return (<Message key={index}
                             oldMessage={oldMessage(index)}
                             content={message.content}
                             user={userIsSender(message) ? userConnected : message.sender}
                             received={!userIsSender(message)}
                             sent={userIsSender(message)}
            />)
        })
    )

    return (<>
        <div className="messages">
            {List}
        </div>

    </>);
}

export default Messages;
