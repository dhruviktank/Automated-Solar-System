var time = "10:20";
console.log(time.split(":"));
var d = new Date();
var newtime = new Date(d.getFullYear(), d.getMonth(), d.getDate()+1, 20, 20)

console.log(newtime.getTime());