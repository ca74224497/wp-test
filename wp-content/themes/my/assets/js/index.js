$(document).ready(function() {
  /**
   * Render list of releases.
   */
  if (typeof releases !== "undefined") {
    renderData(releases);
  }

  /**
   * Pagination.
   */
  $(document).on("click", ".ui.pagination .item", function() {
    var page;
    var $e = $(this);
    var $root = $e.parent();

    if ($e.hasClass("active")) {
      return;
    }
    if ($e.hasClass("nav")) {
      page = $root.find(".active").attr("data-index");
      if ($e.hasClass("prev")) {
        if (page < 2) {
          return;
        }
        page--;
      } else {
        var pages = $root.find(".item:not(.nav)").length;
        if (page == pages) {
          return;
        }
        page++;
      }
    } else {
      page = $e.attr("data-index");
    }

    if (isNaN(page)) {
      return;
    }

    $root
      .find(".active")
      .removeClass("active")
      .parent()
      .find("[data-index=" + page + "]")
      .addClass("active");

    /**
     * Get data from server.
     */
    getData();
  });

  /**
   * Show modal "Add music release" on button click.
   */
  $(".control__add-release").on("click", function() {
    $(".modal.add-release")
      .modal({
        onVisible: function() {
          // Init calendar.
          $(".add-release .ui.calendar").calendar({
            type: "date"
          });
        }
      })
      .modal("show");
  });

  /**
   * Add tracklist.
   */
  $(".add-tracklist-btn").on("click", function(e) {
    $(".add-tracklist").modal("show");
    e.preventDefault();
  });

  /**
   * Add item to tracklist.
   */
  $(".add-track-btn").on("click", function() {
    var ok = true;
    var item = {};
    var inputs = $(this)
      .closest(".fields")
      .find("[name]")
      .each(function() {
        var $e = $(this);
        var $container = $e.closest(".field");
        if (!$e.val().length ||
          (~$e.attr("name").indexOf("duration") && !/^\d{2}:\d{2}$/.test($e.val()))) {
          if (!$container.hasClass("error")) {
            $container.addClass("error");
          }
          if (ok) {
            ok = !ok;
          }
        } else {
          if ($container.hasClass("error")) {
            $container.removeClass("error");
          }
          item[$e.attr("name")] = $e.val();
        }
      });

    if (ok) {
      inputs
        .val("")
        .closest(".modal")
        .find(".output")
        .append(
          $("<li/>")
            .text(item["track-name"] + " (" + item["track-duration"] + ")")
            .attr({
              "data-name" : item["track-name"],
              "data-duration" : item["track-duration"]
            })
        );
    }
  });

  /**
   * Clear tracklist.
   */
  $(".clear-tracklist-btn").on("click", function() {
    $(".modal.add-tracklist .output").empty();
  });

  /**
   * Save tracklist.
   */
  $(".tracklist-okay-btn").on("click", function() {
    var tracklist = [];
    $(this)
      .closest(".modal")
      .find(".output li")
      .each(function() {
        tracklist.push({
          track:  $(this).attr("data-name"),
          length: $(this).attr("data-duration")
        });
      });
    tracklist = encodeURIComponent(
      JSON.stringify(tracklist.sortBy("track"))
    );
    $("[name=release-tracklist]").val(tracklist);
    $(".modal.add-release").modal("show");
  });

  /**
   * Add new music release.
   */
  $(".add-release-btn").on("click", function() {
    var ok = true;
    var params = {};
    $(this)
      .closest(".modal")
      .find(".form [name]")
      .each(function() {
        var $e = $(this);
        var $container = $e.closest(".field");
        if ($e.val().length) {
          if ($container.hasClass("error")) {
            $container.removeClass("error");
          }
          params[$e.attr("name")] = ~$e.attr("name").indexOf("tracklist") ?
            $e.val() : encodeURIComponent($e.val());
        } else {
          if (!$container.hasClass("error")) {
            $container.addClass("error");
          }
          if (ok) {
            ok = !ok;
          }
        }
      });

    if (ok) {
      var $submit  = $(this).addClass("loading");
      var $header  = $submit.closest(".modal").find(".header");
      var template = "<div class='ui red large label'>%error%</div>";
      /**
       * Send ajax-request to server.
       */
      params.action = "add_release";
      $.post(AJAX_ENDPOINT, params)
        .done(function(response) {
          try {
            response = JSON.parse(response);
            if (response.status === "success") {
              // Close modal.
              $header.parent().modal("hide");
              // Refresh page.
              location.reload();
            } else {
              $header.html(
                template.replace("%error%", "Could not add release!")
              );
              console.log(response.message);
            }
          } catch (e) {
            $header.html(
              template.replace("%error%", "Error!")
            );
            console.log(e.message);
          }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          $header.html(
            template.replace("%error%", "Error!")
          );
          console.log(errorThrown);
        })
        .always(function() {
          $submit.removeClass("loading");
        });
    }
  });

  /**
   * Open filtering modal.
   */
  $(".ui.button.filtering").on("click", function() {
    $(".filtering.modal")
      .modal({
        onVisible: function() {
          // Init calendar.
          $(".filtering .ui.calendar").calendar({
            type: "year"
          });
        }
      })
      .modal("show");
  });

  /**
   * Click on filtering okay button.
   */
  $(".filtering-okay-btn").on("click", getData);

  /**
   * Click on filtering reset button.
   */
  $(".filtering-reset-btn").on("click", function() {
    $(this)
      .closest(".modal")
      .find(".dropdown")
      .dropdown("clear");
    $(this)
      .closest(".modal")
      .find(".form [name]")
      .each(function() {
        $(this).val('');
      });
    $(this).next().click();
  });
});

/**
 * Add cards to releases area.
 * @param {array} releases.
 */
function addItems(releases) {
  var template = $("#releases-tpl").html();
  $(".releases").html(
    Tangular.render(template, {items: releases})
  );
  // Activate cards hover effects.
  $(".special.cards .image").dimmer({
    on: "hover"
  });
  // Activate dropdowns.
  $(".ui.dropdown").dropdown();
  // Init sorting handler.
  $(".ui.dropdown.sorting")
    .dropdown("setting", "onChange", getData);
}

/**
 * Get releases data.
 */
function getData() {
  var $active = $(".ui.pagination .item.active");
  var $receiver = $(".releases").addClass("hidden");
  var params = {
    page: isNaN($active.attr("data-index")) ? 1 : $active.attr("data-index"),
    nonce: $(".control").attr("data-nonce"),
    action: "get_data",
    sorting: $("[name=release-sorting]").val()
  };
  $(".modal.filtering")
    .find(".form [name]")
    .each(function() {
      params[$(this).attr("name")] = $(this).val();
    });
  $receiver.prev().addClass("active");
  $.post(AJAX_ENDPOINT, params)
    .done(function(response) {
      try {
        response = JSON.parse(response);
        if (response.status === "success") {
          renderData(response.message);
        } else {
          console.log(response.message);
        }
      } catch (e) {
        console.log(e.message);
      }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    })
    .always(function() {
      $receiver
        .removeClass("hidden")
        .prev()
        .removeClass("active");
    });
}

/**
 * Render data.
 * @param {array} data Releases data.
 */
function renderData(data) {
  var items = [];
  var $pagination = $(".ui.pagination");
  var template = $("#pagination-tpl").html();
  var pp = $pagination.attr("data-per-page");
  var total = data.pagination.total;
  var pages = Math.ceil(total / pp);
  var active = $pagination.find(".active").attr("data-index");

  $(".label.total > .amount").text(total);
  addItems(data.items);

  if (isNaN(active)) {
    active = 1;
  }

  if (active > pages) {
    active = pages;
  }

  for (var i = 0; i < pages; i++) {
    items.push(i + 1);
  }
  $pagination.html(
    Tangular.render(template, {
      items: items,
      active: active
    })
  );
}

/**
 * Sorting array of objects by specific value.
 * @param p
 * @returns {*[]}
 */
Array.prototype.sortBy = function(p) {
  return this.slice(0).sort(function(a,b) {
    return (a[p] > b[p]) ? 1 : (a[p] < b[p]) ? -1 : 0;
  });
}

var AJAX_ENDPOINT = location.origin + "/wp-admin/admin-ajax.php";