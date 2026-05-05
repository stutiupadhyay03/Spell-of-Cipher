// 
const d = new Date();
var seconds = d.getSeconds();
var minutes = d.getMinutes();
var hours = d.getHours();
hours=hours*3600;
minutes=minutes*60;
seconds+=minutes+hours;
var day = d.getDate();
day=30-day-1;

$(document).ready(function() {
$('.countdown').final_countdown({
start: seconds,
end: 1159200,
now: seconds,
selectors: {
    value_seconds: '.clock-seconds .val',
    canvas_seconds: 'canvas_seconds',
    value_minutes: '.clock-minutes .val',
    canvas_minutes: 'canvas_minutes',
    value_hours: '.clock-hours .val',
    canvas_hours: 'canvas_hours',
    value_days: '.clock-days .val',
    canvas_days: 'canvas_days'
},
seconds: {
    borderColor: '#6bcbda',
    borderWidth: '6'
},
minutes: {
    borderColor: '#fc05ec',
    borderWidth: '6'
},
hours: {
    borderColor: '#60fc05',
    borderWidth: '6'
},
days: {
    borderColor: 'tomato',
    borderWidth: '6'
}}, function() {
// Finish callback
});
});