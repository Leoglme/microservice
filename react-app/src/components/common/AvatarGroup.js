import React from 'react';

function AvatarGroup({max, children, size}) {
    const computeSize = size || 40;
    return (<>
        <div className="avatar-group">
            {children.slice(0, max)}
            <div style={{
                borderRadius: 45,
                width: computeSize, height: computeSize,
                fontSize: `calc(14.5px * ${computeSize} / 30)`
            }}
                 className="avatar avatar-count">
                <h5>+5</h5>
            </div>
        </div>
    </>);
}

export default AvatarGroup;
