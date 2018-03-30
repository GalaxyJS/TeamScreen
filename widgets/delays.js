/**
 * Constants
 * @type {number}
 */
TRAFFIC_MAX_OK_DELAY_MINS = 5;
TRAFFIC_MIN_BAD_DELAY_MINS = 15;

/**
 * TRAFFIC WIDGET
 *
 * Authors: Dominic Dingena & Carina Boom
 */
class TrafficWidget{
    /**
     * Constructor
     */
    constructor(){
        this.service = new google.maps.DistanceMatrixService();
        this.list = {};
        this.listCounter = 0;
        this.listbox = document.getElementById("traffic-list");
        this.elements = {};
    }

    /**
     * Get traffic information
     *
     * @param member the member
     * @param callback the function to call on complete
     * @param widget the widget object
     */
    getTrafficInformation(member, callback, widget){
        var param = {
            origins: ['Hilversum'],
            destinations: [member.destination],
            travelMode: 'DRIVING', //Default is DRIVING; for other modes, a paid Premium Google API is needed.
            drivingOptions: {
                departureTime: new Date()
            }
        };
        this.service.getDistanceMatrix(param, function(response){
           callback(member, response, widget);
        });
    }

    /**
     * Update widget with traffic information and DOM information
     */
    update(){
        var widget = this;
        this.elements = {};
        widget.list = teamMembers;
        widget.listCounter = 0;
        widget.list.forEach(function(item) {
            widget.getTrafficInformation(item, widget.updateDOM, widget);
        });
    }

    /**
     * Update the DOM:
     * Calculate delays, statuses, adding a status-icon per user.
     *
     * @param member member from list
     * @param response the response from google API
     * @param widget the widget object
     */
    updateDOM(member, response, widget){
        var result = response.rows[0].elements[0];

        // Valid address
        if (result.status == 'OK') {
            var listItem = widget.addValidAddress(result, member);

            // Invalid address
        } else{
            var listItem = widget.addInvalidAddress(member);
        }
        widget.elements[member.name] = listItem;

        widget.listCounter++;
        // Sort and append items when iteration is complete.
        if (widget.listCounter === widget.list.length){
            var sorted= Object.keys(widget.elements)
                    .sort()
                    .map(function(k) { return widget.elements[k] });
            for (var el in sorted){
                widget.listbox.appendChild(sorted[el]);
            }
        }
    }

    /**
     * Add invalid address
     *
     * @param member the member
     * @return DOM object showing delay status
     */
    addInvalidAddress(member) {
        var listItem = document.createElement('div');
        listItem.className = "traffic-item";

        var img = document.createElement('img');
        img.src = member.avatar;
        img.className = "avatar";
        listItem.appendChild(img);

        var nameSpan = document.createElement('span');
        nameSpan.innerText = member.name;
        nameSpan.className = "name";
        listItem.appendChild(nameSpan);

        var statusSpan = document.createElement('span');
        statusSpan.className = "status bad";
        statusSpan.innerText = "invalid address";
        listItem.appendChild(statusSpan);
        return listItem;
    }

    /**
     * Add valid address
     *
     * @param result the result from google API
     * @param member the member
     * @return DOM object showing delay status
     */
    addValidAddress(result, member) {
        var diff = result.duration_in_traffic.value - result.duration.value;
        var diffInMinutes = Math.round(diff / 60);

        var listItem = document.createElement('div');
        listItem.className = "traffic-item";

        var img = document.createElement('img');
        img.src = member.avatar;
        img.className = "avatar";
        listItem.appendChild(img);

        var nameSpan = document.createElement('span');
        nameSpan.innerText = member.name;
        nameSpan.className = "name";
        listItem.appendChild(nameSpan);


        var statusSpan = document.createElement('span');
        statusSpan.className = "status";

        var delaySpan = document.createElement('span');
        delaySpan.innerText = diffInMinutes + ' min. ';
        delaySpan.className = "status-delay";
        statusSpan.appendChild(delaySpan);

        var statusIcon = document.createElement('img');
        statusIcon.className = "status-icon";
        if (diffInMinutes < TRAFFIC_MAX_OK_DELAY_MINS) {
            statusSpan.className = "status ok";
            statusIcon.src = "widgets/greenSmiley.png";
        } else if (diffInMinutes > TRAFFIC_MIN_BAD_DELAY_MINS) {
            statusSpan.className = "status bad";
            statusIcon.src = "widgets/redSmiley.png";
        } else {
            statusSpan.className = "status moderate";
            statusIcon.src = "widgets/orangeSmiley.png";
        }
        statusSpan.appendChild(statusIcon);
        listItem.appendChild(statusSpan);
        return listItem;
    }
}

/**
 * Callback for Google API
 */
function initTraffic() {
    var trafficWidget = new TrafficWidget;
    trafficWidget.update();
}
