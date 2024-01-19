const header_checkbox = document.getElementById("header_checkbox");
const posts_checkboxes = document.querySelectorAll('[id="post_checkbox"]');

header_checkbox.addEventListener("change", () => {
  const isChecked = header_checkbox.checked;
  toggleAllPostCheckboxes(isChecked);
});

function toggleAllPostCheckboxes(isChecked) {
  posts_checkboxes.forEach((checkbox) => {
    if (isChecked) {
      checkbox.checked = true;
      return;
    }
    checkbox.checked = false;
  });
}

$(document).ready(function () {
  $("#summernote").summernote();
});

const div_box = "<div id='load-screen'><div id='loading'> </div></div>";

$("body").prepend(div_box);

$("#load-screen")
  .delay(700)
  .fadeOut(600, () => $(this).remove());
