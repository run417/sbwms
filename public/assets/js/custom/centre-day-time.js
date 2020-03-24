const checkbox = $('input[type=checkbox]').filter(':not(input[name=\'day[default]\'])');
const defaultCheckbox = $('input[name=\'day[default]\']');
const openDefault = $('input[name=\'open[default]\']');
const closeDefault = $('input[name=\'close[default]\']');
const openTimes = $('input[name^=\'open\']').filter(':not(input[name=\'open[default]\'])');
const closeTimes = $('input[name^=\'close\']').filter(':not(input[name=\'close[default]\'])');

checkbox.on('click', checkboxHandler);
defaultCheckbox.on('click', makeTimesReadonly);
openDefault.on('changeTime', defaultOpenHandler);
closeDefault.on('changeTime', defaultCloseHandler);

function makeTimesReadonly() {
    if (this.checked) {
        openTimes.prop('readonly', true);
        closeTimes.prop('readonly', true);
        openDefault.prop('readonly', false);
        closeDefault.prop('readonly', false);
        defaultOpenHandler(null, openDefault.val());
        defaultCloseHandler(null, closeDefault.val());
    } else {
        openTimes.prop('readonly', false);
        closeTimes.prop('readonly', false);
        openDefault.prop('readonly', true).val('');
        closeDefault.prop('readonly', true).val('');
    }
}

function defaultOpenHandler(e, val = 0) {
    let v = val;
    if (val === 0) { v = this.value; }

    openTimes.each((i, el) => {
        // console.log(this);
        let day = getDayName(el);
        let c = $(`[name='day[${day}]']`);
        if (c.prop('checked')) {
            $(`input[name='open[${day}]']`).val(v);
        } else {
            $(`input[name='open[${day}]']`).val('');
        }
    });
}

function defaultCloseHandler(e, val = 0) {
    let v = val;
    if (val === 0) { v = this.value; }
    openTimes.each((i, el) => {
        let day = getDayName(el);
        let c = $(`[name='day[${day}]']`);
        if (c.prop('checked')) {
            $(`input[name='close[${day}]']`).val(v);
        } else {
            $(`input[name='close[${day}]']`).val('');
        }
    });
}

function getDayName(element) {
    return (element.name.slice((element.name.indexOf('[') + 1), element.name.lastIndexOf(']')));
}

function checkboxHandler() {
    let day = getDayName(this);
    let selector1 = `input[name='open[${day}]']`;
    let selector2 = `input[name='close[${day}]']`;
    if (defaultCheckbox.prop('checked')) {
        $(selector1).val(openDefault.val());
        $(selector2).val(closeDefault.val());
    }
    if (this.checked) {
        enableInput(selector1, selector2);
    } else {
        disableInput(selector1, selector2);
        if (defaultCheckbox.prop('checked')) {
            $(selector1).val('');
            $(selector2).val('');
        }
    }
}

function disableInput(selector1, selector2) {
    $(selector1).prop('disabled', true);
    $(selector2).prop('disabled', true);
}
function enableInput(selector1, selector2) {
    $(selector1).prop('disabled', false);
    $(selector2).prop('disabled', false);
}
