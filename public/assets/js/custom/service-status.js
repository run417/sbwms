console.log('hi');
console.log(urlFor('/assets'));

function checkAndUpdateStatus() {
    return $.ajax({
        method: 'GET',
        url: urlFor('/service/check-update-status'),
    }).fail((jqhr, err) => {
        console.log(err, 'status change failed');
    });
}

// const twoMinuteMilliseconds = 120000;
// const twoMinuteMilliseconds = 60000;
checkAndUpdateStatus();
setInterval(checkAndUpdateStatus, 60000);
