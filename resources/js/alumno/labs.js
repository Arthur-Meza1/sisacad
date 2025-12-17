import {ContentLoader} from "../common/ContentLoader.js";
import $ from "jquery";

window.enrollLab = enrollLab;
window.removeEnrollment = removeEnrollment;

function enrollLab(labId) {
  const data = {
    'id': labId,
    '_token': $('meta[name="csrf-token"]').attr('content')
  };

  $.post('/api/student/matricular', data)
    .done(function() {
      window.location.reload();
    })
    .fail(function (data) {
      console.error(data.responseText);
    });
}

function removeEnrollment(labId) {
  const data = {
    'id': labId,
    '_token': $('meta[name="csrf-token"]').attr('content')
  };

  $.post('/api/student/desmatricular', data)
    .done(function() {
      window.location.reload();
    })
    .fail(function (data) {
      console.error(data.responseText);
    });
}
