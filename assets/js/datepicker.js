"use strict";
$.filterDates = function( filterDay ) {
    var oneDayInMs = 86400000;
    var dates = [];
    var start = new Date();
    for( var i = 1; i <= 365; i++ ) {
        var aDay = oneDayInMs * i;
        var tsDay = start.getTime() + aDay;
        var nDate = new Date( tsDay );
        if( nDate.getDay() !== parseInt( filterDay, 10 ) ) {
            var yy = nDate.getFullYear().toString();
            var mm = ( ( nDate.getMonth() + 1 ) < 10 ) ? '0' + ( nDate.getMonth() + 1 ).toString() : ( nDate.getMonth() + 1 ).toString();
            var dd = ( nDate.getDate() < 10 ) ? '0' + ( nDate.getDate() ).toString() : ( nDate.getDate() ).toString();
            var date = yy + "-" + mm + "-" + dd;
            dates.push( date );
        }
    }
    return dates;
};