import React from 'react';

function MessageField(props) {
    return (<>
        <div className="field-box">
            <textarea className='message-field'
                      placeholder="Your Message"
                      name="message-field"
                      id="message-field"
                      cols="30" rows="1"/>
        </div>
    </>);
}

export default MessageField;
