var scrollerl = 0;
var scrollerr = 0;

var updatever = 0;
var deletever = 0;
var newbiever = 0;


function lefter() {
  $("#left").animate({
    scrollTop: scrollerl
  }, 1000,"linear", function() {
    if(parseInt($("#left").children().first().outerHeight(),10)+10<=(scrollerl)){
      scrollerl -= parseInt($("#left").children().first().outerHeight(),10) +10;
      $("#left").children().first().detach().appendTo($("#left"));
    }
    scrollerl+=50;
    // Animation complete.
    lefter();
  })
}

function righter() {
  //console.log("R");
  $("#right").animate({
    scrollTop: scrollerr
  }, 1000,"linear", function() {
    if(parseInt($("#right").children().first().outerHeight(),10)+15<=(scrollerr)){
      scrollerr -= parseInt($("#right").children().first().outerHeight(),10) +15;
      $("#right").children().first().detach().appendTo($("#right"));
    }
    scrollerr+=50;
    // Animation complete.
    righter();
  })
}
function t(s) {
  if (s >= 3600)
    return Math.floor(s / 3600) % 60 + ':' +
      (Math.floor(s / 60) % 60 > 9 ? Math.floor(s / 60) % 60 :
        '0' + Math.floor(s / 60) % 60) +
      ':' + (s % 60 > 9 ? s % 60 : '0' + s % 60);
  else if (s >= 60)
    return Math.floor(s / 60) % 60 + ':' + (s % 60 > 9 ? s % 60 : '0' + s % 60);
  else
    return s;
}


function updates() {
  // newbie
  console.log('up');
  console.log(newbiever);
  $.getJSON('../backend/night/getnewbie.php?v=' + newbiever, function (data) {
    $.each(data, function (key, val2) {
      if (parseInt(val2.version, 10) >= newbiever)
        newbiever = parseInt(val2.version, 10) + 1;
      console.log(newbiever);
      cat = $('body').find('category[cat=\'' + val2.category + '\']');
      if (val2.status != 0) {
        pozs = 'Hiba';
        cat.append(
          '<result valid=\'false\' rid=' + val2.id + ' time=' + val2.time +
          ' ><pos>' + pozs + '</pos><name>' + val2.lastname + ' ' +
          val2.firstname + '</name><club>' + val2.club + '</club><stime>' +
          t(val2.time) + '</stime><stimediff>-</stimediff></result>');
      } else {
        // console.log(cat.children().length);
        var i = 0;
        if (cat.find('result[valid=\'true\']').length == 0)
          cat.find('result.top')
          .after(
            '<result valid=\'true\' rid=' + val2.id +
            ' time=' + val2.time + ' ><pos>1</pos><name>' +
            val2.lastname + ' ' + val2.firstname + '</name><club>' +
            val2.club + '</club><stime>' + t(val2.time) +
            '</stime><stimediff></stimediff></result>');
        else {
          // console.log(
          //    cat.find('result[valid=\'true\']:eq(' + i + ')').length);
          var found = false;
          while (!found) {
            // console.log(cat.find('result[valid=\'true\']:eq(' + i +
            // ')').attr("time"));
            if (parseInt(
                cat.find('result[valid=\'true\']:eq(' + i + ')')
                .attr('time'),
                10) > val2.time) {
              var timediff = i ? '+' +
                t(val2.time -
                  cat.find('result[valid=\'true\']:eq(0)').attr('time')) :
                '';
              cat.find('result[valid=\'true\']:eq(' + i + ')')
                .before(
                  '<result valid=\'true\' rid=' + val2.id +
                  ' time=' + val2.time + ' ><pos>' +
                  cat.find('result[valid=\'true\']:eq(' + i + ')')
                  .find('pos')
                  .html() +
                  '</pos><name>' + val2.lastname + ' ' + val2.firstname +
                  '</name><club>' + val2.club + '</club><stime>' +
                  t(val2.time) + '</stime><stimediff>' + timediff +
                  '</stimediff></result>');
              // cat.find('result[valid=\'true\']:eq(' + i + ')')
              while (cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                .length != 0) {
                cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                  .find('pos')
                  .html(
                    parseInt(
                      cat.find(
                        'result[valid=\'true\']:eq(' + (i + 1) + ')')
                      .find('pos')
                      .html(),
                      10) +
                    1)
                cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                  .find('stimediff')
                  .html(
                    '+' +
                    t(parseInt(
                        cat.find(
                          'result[valid=\'true\']:eq(' + (i + 1) +
                          ')')
                        .attr('time'),
                        10) -
                      cat.find('result[valid=\'true\']:eq(0)')
                      .attr('time')))
                i++;
              }
              found = true;
            } else if (
              cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')').length ==
              0) {
              var timediff = '+' +
                t(val2.time -
                  parseInt(
                    cat.find('result[valid=\'true\']:eq(0)').attr('time'),
                    10));

              cat.find('result[valid=\'true\']:eq(' + i + ')')
                .after(
                  '<result valid=\'true\' rid=' + val2.id +
                  ' time=' + val2.time + ' ><pos>' +
                  (parseInt(
                      cat.find('result[valid=\'true\']:eq(' + (i) + ')')
                      .find('pos')
                      .html(),
                      10) +
                    1) +
                  '</pos><name>' + val2.lastname + ' ' + val2.firstname +
                  '</name><club>' + val2.club + '</club><stime>' +
                  t(val2.time) + '</stime><stimediff>' + timediff +
                  '</stimediff></result>');
              found = true;
            }
            i++;
          }
        }
      }
    });
  });
  //$.getJSON('backend/day1/getnewbiever.php', function(data) {
  //  if (data['newbie'] != null) newbiever = parseInt(data['newbie'],10) +1 ;
  //  console.log(newbiever);
  //});
  // update
  $.getJSON('../backend/night/getupdate.php?v=' + updatever, function (data) {
    $.each(data, function (key, val) {
      if (parseInt(val.version, 10) >= updatever)
        updatever = parseInt(val.version, 10) + 1;
      runner = $('body').find('result[rid=\'' + val.id + '\']');
      runner.find("stime").html(t(val.time));
      if ((parseInt(val.status, 10) == 0 ^ runner.attr('valid') != 'false') ||
        parseInt(val.time, 10) != parseInt(runner.attr('time'), 10)) {
        cat = runner.parent();
        if (parseInt(val.status, 10) == 0 && runner.attr('valid') == 'false') {
          // hibásból jó
          runner.attr("time", val.time);

          console.log("hibasboljo");
          runner.attr("valid", "false");

          if (cat.find('result[valid=\'true\']').length == 0) {
            runner.detach().insertAfter(cat.find('result.top'));
            runner.find("pos").html("1");
            runner.find("stimediff").html("-");
            //újraszámolás
          } else {
            var found = false;
            var i = 0;

            while (!found) {
              // console.log(cat.find('result[valid=\'true\']:eq(' + i +
              // ')').attr("time"));
              if (parseInt(
                  cat.find('result[valid=\'true\']:eq(' + i + ')')
                  .attr('time'),
                  10) > val.time) {
                runner.detach().insertBefore(cat.find('result[valid=\'true\']:eq(' + i + ')'));
                runner.find("pos").html(cat.find('result[valid=\'true\']:eq(' + i + ')').find("pos").html());
                if (i == 0) runner.find("stimediff").html("");
                else runner.find("stimediff").html("+" + t(parseInt(runner.attr("time"), 10) - parseInt(cat.find("result[valid=\'true\']").attr("time"), 10)));
                // cat.find('result[valid=\'true\']:eq(' + i + ')')
                while (
                  cat.find('result[valid=\'true\']:eq(' + i + ')')
                  .length != 0) {
                  cat.find('result[valid=\'true\']:eq(' + i + ')').find('pos').html(parseInt(cat.find('result[valid=\'true\']:eq(' + i + ')').find('pos').html(), 10) + 1);
                  cat.find('result[valid=\'true\']:eq(' + i + ')')
                    .find('stimediff')
                    .html('+' + t(parseInt(cat.find('result[valid=\'true\']:eq(' + i + ')').attr('time'), 10) - parseInt(cat.find('result:not(.top):eq(0)').attr('time'), 10)));
                  i++;
                }
                found = true;
              } else if (
                cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                .length == 0) {
                var timediff = '+' +
                  t(val.time -
                    cat.find('result[valid=\'true\']:eq(0)')
                    .attr('time'));

                runner.detach().insertAfter(cat.find('result[valid=\'true\']:eq(' + i + ')'));

                found = true;
              }
              i++;
            }

          }
          runner.attr("valid", "true");

        } else if (
          parseInt(val.status, 10) != 0 && runner.attr('valid') == 'true') {
          runner.attr("time", val.time);

          // jóból hibás
          console.log("jobolhibas");
          console.log(runner[0] == cat.find("result:not(.top):eq(0)")[0]);
          if (runner[0] == cat.find("result:not(.top):eq(0)")[0]) {
            //stimediffujraszámolás
            //helyezésujraszámolás
            var first = true;
            var r = runner.next("result[valid=\'true\']");
            while (r.length != 0) {
              r.find("pos").html(parseInt(r.find("pos").html(), 10) - 1);
              if (first) {
                first = false;
                r.find("stimediff").html("");
              } else {
                r.find("stimediff").html("+" + t(parseInt(r.attr("time"), 10) - parseInt(runner.next("result[valid=\'true\']").attr("time"), 10)));
              }
              r = r.next("result[valid=\'true\']");

            }
          } else {
            //helyezésujraszámolás
            var r = runner.next("result[valid=\'true\']");
            while (r.length != 0) {
              r.find("pos").html(parseInt(r.find("pos").html(), 10) - 1);
              r = r.next("result[valid=\'true\']");
            }
          }
          runner.detach().appendTo(cat).find("pos").html("Hiba");
          runner.find("stimediff").html("-");
          runner.attr("valid", "false");
        } else if (
          parseInt(val.time, 10) != parseInt(runner.attr['time'], 10)) {
          // időváltozás
          if (val.status != 0) {
            runner.attr("time", val.time);
          } else {
            runner.attr("time", val.time);

            if (runner[0] == cat.find("result:not(.top):eq(0)")[0]) {
              //pos ujraosztás
              var found = false;
              var i = 0;

              runner.detach();
              while (!found) {
                if (parseInt(cat.find("result[valid=\'true\']:eq(" + i + ")").attr("time"), 10) > parseInt(val.time, 10)) {
                  runner.insertBefore(cat.find("result[valid=\'true\']:eq(" + i + ")"));
                  found = true;
                }
                if (cat.find("result[valid=\'true\']:eq(" + (i + 1) + ")").length == 0) {
                  runner.insertAfter(cat.find("result[valid=\'true\']:eq(" + i + ")"));
                  found = true;
                }
                i++;
              }
              var r = cat.find("result[valid=\'true\']:eq(0)");
              r.find("stimediff").html("-");
              r.find("pos").html("1");
              var i = 2;
              r = r.next("result[valid=\'true\']");
              while (r.length != 0) {
                r.find("pos").html(i);
                r.find("stimediff").html("+" + t(parseInt(r.attr("time"), 10) - parseInt(cat.find("result[valid=\'true\']:eq(0)").attr("time"), 10)));
                r = r.next("result[valid=\'true\']");
                i++;
              }

              //stimediff újra

            } else {
              var found = false;
              var i = 0;
              runner.detach();
              while (!found) {
                if (parseInt(cat.find("result[valid=\'true\']:eq(" + i + ")").attr("time"), 10) > parseInt(val.time, 10)) {
                  runner.insertBefore(cat.find("result[valid=\'true\']:eq(" + i + ")"));
                  found = true;
                }
                if (cat.find("result[valid=\'true\']:eq(" + (i + 1) + ")").length == 0) {
                  runner.insertAfter(cat.find("result[valid=\'true\']:eq(" + i + ")"));
                  found = true;
                }
                i++;
              }
              var r = cat.find("result[valid=\'true\']:eq(0)");
              r.find("stimediff").html("-");
              r.find("pos").html("1");
              var i = 2;
              r = r.next("result[valid=\'true\']");
              while (r.length != 0) {
                r.find("pos").html(i);
                r.find("stimediff").html("+" + t(parseInt(r.attr("time"), 10) - parseInt(cat.find("result[valid=\'true\']:eq(0)").attr("time"), 10)));
                r = r.next("result[valid=\'true\']");
                i++;
              }
              //pos ujraosztás
            }

          }
        }
      }
    });
  });
  // delete
  $.getJSON('../backend/night/getdelete.php?v=' + deletever, function (data) {
    $.each(data, function (key, val) {
      if (parseInt(val.version, 10) >= deletever)
        deletever = parseInt(val.version, 10) + 1;
      runner = $('body').find('result[rid=\'' + val.id + '\']');
      cat = runner.parent();
      runner.remove();
      var r = cat.find("result[valid=\'true\']:eq(0)");
      r.find("stimediff").html("-");
      r.find("pos").html("1");
      var i = 2;
      r = r.next("result[valid=\'true\']");
      while (r.length != 0) {
        r.find("pos").html(i);
        r.find("stimediff").html("+" + t(parseInt(r.attr("time"), 10) - parseInt(cat.find("result[valid=\'true\']:eq(0)").attr("time"), 10)));
        r = r.next("result[valid=\'true\']");
        i++;
      }
    });
  });

  /*console.log(updatever);
  console.log(newbiever);
  console.log(deletever);*/
}


$(document).ready(function () {
  // setInterval(explode, 1000);

  setTimeout(lefter, 2000);
  setTimeout(righter, 2000);

  $.getJSON('../backend/night/getvers.php', function (data) {
    if (data['newbie'] != null) newbiever = parseInt(data['newbie'], 10) + 1;
    console.log(newbiever);
    if (data['update'] != null) updatever = parseInt(data['update'], 10) + 1;
    console.log(updatever);
    if (data['delete'] != null) deletever = parseInt(data['delete'], 10) + 1;
    console.log(deletever);
  });

  $.getJSON('../backend/getcate.php?s=0', function (data) {
    $.each(data, function (key, val) {
      $('#left').append(
        '<category cat="' + val.cat + '"><cnamebox><cname>' + val.cat +
        '</cname></cnamebox><result class="top"><pos>Hely</pos><name>Név</name><club>Egyesület</club><stime>Idő</stime><stimediff>Időkül.</stimediff></result></category>');
      $.getJSON(
        '../backend/night/runnerfromcat.php?cat=' + val.cat,
        function (data) {
          $.each(data, function (key2, val2) {
            // console.log(val2);
            cat = $('body').find('category[cat=\'' + val.cat + '\']');
            if (val2.status != 0) {
              pozs = 'Hiba';
              cat.append(
                '<result valid=\'false\' rid=' + val2.id +
                ' time=' + val2.time + ' ><pos>' + pozs + '</pos><name>' +
                val2.lastname + ' ' + val2.firstname + '</name><club>' +
                val2.club + '</club><stime>' + t(val2.time) +
                '</stime><stimediff>-</stimediff></result>');
            } else {
              // console.log(cat.children().length);
              var i = 0;
              if (cat.find('result[valid=\'true\']').length == 0)
                cat.find('result.top')
                .after(
                  '<result valid=\'true\' rid=' + val2.id + ' time=' +
                  val2.time + ' ><pos>1</pos><name>' + val2.lastname +
                  ' ' + val2.firstname + '</name><club>' + val2.club +
                  '</club><stime>' + t(val2.time) +
                  '</stime><stimediff></stimediff></result>');
              else {
                // console.log(
                //    cat.find('result[valid=\'true\']:eq(' + i +
                //    ')').length);
                var found = false;
                while (!found) {
                  // console.log(cat.find('result[valid=\'true\']:eq(' + i +
                  // ')').attr("time"));
                  if (parseInt(
                      cat.find('result[valid=\'true\']:eq(' + i + ')')
                      .attr('time'),
                      10) > val2.time) {
                    var timediff = i ? '+' +
                      t(val2.time -
                        cat.find('result[valid=\'true\']:eq(0)')
                        .attr('time')) :
                      '';
                    cat.find('result[valid=\'true\']:eq(' + i + ')')
                      .before(
                        '<result valid=\'true\' rid=' + val2.id +
                        ' time=' + val2.time + ' ><pos>' +
                        cat.find('result[valid=\'true\']:eq(' + i + ')')
                        .find('pos')
                        .html() +
                        '</pos><name>' + val2.lastname + ' ' +
                        val2.firstname + '</name><club>' + val2.club +
                        '</club><stime>' + t(val2.time) +
                        '</stime><stimediff>' + timediff +
                        '</stimediff></result>');
                    // cat.find('result[valid=\'true\']:eq(' + i + ')')
                    while (
                      cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                      .length != 0) {
                      cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                        .find('pos')
                        .html(
                          parseInt(
                            cat.find(
                              'result[valid=\'true\']:eq(' +
                              (i + 1) + ')')
                            .find('pos')
                            .html(),
                            10) +
                          1)
                      cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                        .find('stimediff')
                        .html(
                          '+' +
                          t(parseInt(
                              cat.find(
                                'result[valid=\'true\']:eq(' +
                                (i + 1) + ')')
                              .attr('time'),
                              10) -
                            cat.find('result[valid=\'true\']:eq(0)')
                            .attr('time')))
                      i++;
                    }
                    found = true;
                  } else if (
                    cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                    .length == 0) {
                    var timediff = '+' +
                      t(val2.time -
                        cat.find('result[valid=\'true\']:eq(0)')
                        .attr('time'));

                    cat.find('result[valid=\'true\']:eq(' + i + ')')
                      .after(
                        '<result valid=\'true\' rid=' + val2.id +
                        ' time=' + val2.time + ' ><pos>' +
                        (parseInt(
                            cat.find(
                              'result[valid=\'true\']:eq(' + (i) +
                              ')')
                            .find('pos')
                            .html(),
                            10) +
                          1) +
                        '</pos><name>' + val2.lastname + ' ' +
                        val2.firstname + '</name><club>' + val2.club +
                        '</club><stime>' + t(val2.time) +
                        '</stime><stimediff>' + timediff +
                        '</stimediff></result>');
                    found = true;
                  }
                  i++;
                }
              }
            }
          });
        });
    });
    // load cat
  });

  $.getJSON('../backend/getcate.php?s=1', function (data) {
    $.each(data, function (key, val) {
      $('#right').append(
        '<category cat="' + val.cat + '"><cnamebox><cname>' + val.cat +
        '</cname></cnamebox><result class="top"><pos>Hely</pos><name>Név</name><club>Egyesület</club><stime>Idő</stime><stimediff>Időkül.</stimediff></result></category>');
      $.getJSON(
        '../backend/night/runnerfromcat.php?cat=' + val.cat,
        function (data) {
          $.each(data, function (key2, val2) {
            // console.log(val2);
            cat = $('body').find('category[cat=\'' + val.cat + '\']');
            if (val2.status != 0) {
              pozs = 'Hiba';
              cat.append(
                '<result valid=\'false\' rid=' + val2.id +
                ' time=' + val2.time + ' ><pos>' + pozs + '</pos><name>' +
                val2.lastname + ' ' + val2.firstname + '</name><club>' +
                val2.club + '</club><stime>' + t(val2.time) +
                '</stime><stimediff>-</stimediff></result>');
            } else {
              // console.log(cat.children().length);
              var i = 0;
              if (cat.find('result[valid=\'true\']').length == 0)
                cat.find('result.top')
                .after(
                  '<result valid=\'true\' rid=' + val2.id + ' time=' +
                  val2.time + ' ><pos>1</pos><name>' + val2.lastname +
                  ' ' + val2.firstname + '</name><club>' + val2.club +
                  '</club><stime>' + t(val2.time) +
                  '</stime><stimediff></stimediff></result>');
              else {
                // console.log(
                //   cat.find('result[valid=\'true\']:eq(' + i + ')').length);
                var found = false;
                while (!found) {
                  // console.log(cat.find('result[valid=\'true\']:eq(' + i +
                  // ')').attr("time"));
                  if (parseInt(
                      cat.find('result[valid=\'true\']:eq(' + i + ')')
                      .attr('time'),
                      10) > val2.time) {
                    var timediff = i ? '+' +
                      t(val2.time -
                        cat.find('result[valid=\'true\']:eq(0)')
                        .attr('time')) :
                      '';
                    cat.find('result[valid=\'true\']:eq(' + i + ')')
                      .before(
                        '<result valid=\'true\' rid=' + val2.id +
                        ' time=' + val2.time + ' ><pos>' +
                        cat.find('result[valid=\'true\']:eq(' + i + ')')
                        .find('pos')
                        .html() +
                        '</pos><name>' + val2.lastname + ' ' +
                        val2.firstname + '</name><club>' + val2.club +
                        '</club><stime>' + t(val2.time) +
                        '</stime><stimediff>' + timediff +
                        '</stimediff></result>');
                    // cat.find('result[valid=\'true\']:eq(' + i + ')')
                    while (
                      cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                      .length != 0) {
                      cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                        .find('pos')
                        .html(
                          parseInt(
                            cat.find(
                              'result[valid=\'true\']:eq(' +
                              (i + 1) + ')')
                            .find('pos')
                            .html(),
                            10) +
                          1)
                      cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                        .find('stimediff')
                        .html(
                          '+' +
                          t(parseInt(
                              cat.find(
                                'result[valid=\'true\']:eq(' +
                                (i + 1) + ')')
                              .attr('time'),
                              10) -
                            cat.find('result[valid=\'true\']:eq(0)')
                            .attr('time')))
                      i++;
                    }
                    found = true;
                  } else if (
                    cat.find('result[valid=\'true\']:eq(' + (i + 1) + ')')
                    .length == 0) {
                    var timediff = '+' +
                      t(val2.time -
                        cat.find('result[valid=\'true\']:eq(0)')
                        .attr('time'));

                    cat.find('result[valid=\'true\']:eq(' + i + ')')
                      .after(
                        '<result valid=\'true\' rid=' + val2.id +
                        ' time=' + val2.time + ' ><pos>' +
                        (parseInt(
                            cat.find(
                              'result[valid=\'true\']:eq(' + (i) +
                              ')')
                            .find('pos')
                            .html(),
                            10) +
                          1) +
                        '</pos><name>' + val2.lastname + ' ' +
                        val2.firstname + '</name><club>' + val2.club +
                        '</club><stime>' + t(val2.time) +
                        '</stime><stimediff>' + timediff +
                        '</stimediff></result>');
                    found = true;
                  }
                  i++;
                }
              }
            }
          });
        });
    });
    // load cat

    // vers
  });
  /*
    $.getJSON('backend/newbiedata.php?v=1', function(data) {
      $.each(data, function(key, val) {
        $.getJSON('backend/newbierunner.php?id=' + val.id, function(data2) {
          $.extend(val, data2[0]);
        });
      });
    });*/

  var updater = setInterval(updates, 5000);
  // loaded = true;
});


//