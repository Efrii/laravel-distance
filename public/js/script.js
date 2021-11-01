$('#btn-link1').click(function() {
  var $input = $("<div id='input-tmbh1' class='input-group mb-3'><span class='input-group-text fab fa-chrome' id='basic-addon1'></span><input name='link1[]' type='text' class='form-control' placeholder='Link Berita 1' aria-label='Username' aria-describedby='basic-addon1'></div>");
  $('#input1').append($input);
});

$('#btn-link2').click(function() {
  var $input = $("<div id='input-tmbh2' class='input-group mb-3'><span class='input-group-text fab fa-chrome' id='basic-addon1'></span><input name='link2[]' type='text' class='form-control' placeholder='Link Berita 2' aria-label='Username' aria-describedby='basic-addon1'></div>");
  $('#input2').append($input);
});

$('#btn-link3').click(function() {
  $('#input-tmbh1').remove();
});

$('#btn-link4').click(function() {
  $('#input-tmbh2').remove();
});

function countWords1() {
  var saved_text = $.trim($("#textBox1").val());
  saved_text = saved_text.replace(/\s+/g, " ");
  saved_text = saved_text.replace(/\n /, " ");
  if (saved_text == "") {
      document.getElementById('word-count1').innerHTML = "0";
  }
  else{
      words_length = saved_text.split(' ').length;
      $('#word-count1').html(words_length);
      $('#word-count_below').html(words_length);
  }
}

function countWords2() {
  var saved_text = $.trim($("#textBox2").val());
  saved_text = saved_text.replace(/\s+/g, " ");
  saved_text = saved_text.replace(/\n /, " ");
  if (saved_text == "") {
      document.getElementById('word-count2').innerHTML = "0";
  }
  else{
      words_length = saved_text.split(' ').length;
      $('#word-count2').html(words_length);
      $('#word-count_below').html(words_length);
  }
}

function countWords3() {
  var saved_text = $.trim($("#textBox3").val());
  saved_text = saved_text.replace(/\s+/g, " ");
  saved_text = saved_text.replace(/\n /, " ");
  if (saved_text == "") {
      document.getElementById('word-count3').innerHTML = "0";
  }
  else{
      words_length = saved_text.split(' ').length;
      $('#word-count3').html(words_length);
      $('#word-count_below').html(words_length);
  }
}

function countWords4() {
  var saved_text = $.trim($("#textBox4").val());
  saved_text = saved_text.replace(/\s+/g, " ");
  saved_text = saved_text.replace(/\n /, " ");
  if (saved_text == "") {
      document.getElementById('word-count4').innerHTML = "0";
  }
  else{
      words_length = saved_text.split(' ').length;
      $('#word-count4').html(words_length);
      $('#word-count_below').html(words_length);
  }
}

function countWords5() {
  var saved_text = $.trim($("#output1").val());
  saved_text = saved_text.replace(/\s+/g, " ");
  saved_text = saved_text.replace(/\n /, " ");
  if (saved_text == "") {
      document.getElementById('word-count5').innerHTML = "0";
  }
  else{
      words_length = saved_text.split(' ').length;
      $('#word-count5').html(words_length);
      $('#word-count_below').html(words_length);
  }
}

function countWords6() {
  var saved_text = $.trim($("#output2").val());
  saved_text = saved_text.replace(/\s+/g, " ");
  saved_text = saved_text.replace(/\n /, " ");
  if (saved_text == "") {
      document.getElementById('word-count6').innerHTML = "0";
  }
  else{
      words_length = saved_text.split(' ').length;
      $('#word-count6').html(words_length);
      $('#word-count_below').html(words_length);
  }
}

$( "#submit" ).click(function() {
  $( '#submit' ).html( "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Tunggu Sedang Mengambil Data..." );
});

$( "#submitJaro" ).click(function() {
  $( '#submitJaro' ).html( "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Tunggu Sedang Cek Plagiarism..." );
});

var openFile1 = function(event) {
  var input = event.target;
  var reader = new FileReader();
  reader.onload = function() {
    var zip = new JSZip(reader.result);
    var doc = new window.docxtemplater().loadZip(zip);
    var text = doc.getFullText();
    var node = document.getElementById('output1');
    node.innerText = text;
    var show = document.getElementById('isi1');
    if (show.style.display === "none") {
      show.style.display = "block";
    } else {
      show.style.display = "none";
    }
  };
  reader.readAsBinaryString(input.files[0]);
};

var openFile2 = function(event) {
  var input = event.target;
  var reader = new FileReader();
  reader.onload = function() {
    var zip = new JSZip(reader.result);
    var doc = new window.docxtemplater().loadZip(zip);
    var text = doc.getFullText();
    var node = document.getElementById('output2');
    node.innerText = text;
    var show = document.getElementById('isi2');
    if (show.style.display === "none") {
      show.style.display = "block";
    } else {
      show.style.display = "none";
    }
  };
  reader.readAsBinaryString(input.files[0]);
};

$(document).ready(function() {
  $('#stopword').DataTable();
});

$(document).ready(function() {
  $('#taghtml').DataTable();
});

MathJax.Hub.Config({
  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
});