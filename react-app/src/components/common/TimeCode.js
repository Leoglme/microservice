import React from 'react';

function TimeCode({time}) {
    return (<>
        <div className={'start'} style={{gap: 5}}>
            <div className="dot-separator bg-orange"/>
            <span style={{fontSize: 9.5, userSelect: 'none'}}>{time}</span>
        </div>
    </>);
}

export default TimeCode;
