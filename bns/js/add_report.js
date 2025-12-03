// Handle CSV file upload and auto-fill form
document.getElementById('csvFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    enableInputs(); // unlock first for re-import
    clearBorders(); // clear old red borders

    const reader = new FileReader();
    reader.onload = function(event) {
        const text = event.target.result;
        const rows = text.split(/\r?\n/).filter(r => r.trim() !== '');

        let values = [];
        for (let i = 0; i < rows.length; i++) {
            const cols = rows[i].split(/\t|,/);
            cols.forEach(cell => {
                let val = cell.trim();
                if (val.endsWith('%')) val = val.replace('%','');
                if (val !== '' && !isNaN(val)) {
                    values.push(val);
                }
            });
        }

        const inputMapping = [
            'ind1','ind_male','ind_female','ind2','ind3','ind4','ind5',
            'ind6a','ind6b','ind7','ind8','ind9','ind9a',

            'ind9b1_no','ind9b1_pct','ind9b2_no','ind9b2_pct','ind9b3_no','ind9b3_pct',
            'ind9b4_no','ind9b4_pct','ind9b5_no','ind9b5_pct','ind9b6_no','ind9b6_pct',
            'ind9b7_no','ind9b7_pct','ind9b8_no','ind9b8_pct','ind9b9_no','ind9b9_pct',

            'ind10','ind11','ind12','ind13','ind14','ind15','ind16',
            'ind17a_public','ind17a_private','ind17b_public','ind17b_private',
            'ind18','ind19','ind20','ind21',

            'ind22a_no','ind22a_pct','ind22b_no','ind22b_pct','ind22c_no','ind22c_pct',
            'ind22d_no','ind22d_pct','ind22e_no','ind22e_pct','ind22f_no','ind22f_pct',
            'ind22g_no','ind22g_pct',

            'ind23','ind24','ind25','ind26',

            'ind27a_no','ind27a_pct','ind27b_no','ind27b_pct','ind27c_no','ind27c_pct',
            'ind27d_no','ind27d_pct','ind27e_no','ind27e_pct',

            'ind28a_no','ind28a_pct','ind28b_no','ind28b_pct','ind28c_no','ind28c_pct',
            'ind28d_no','ind28d_pct',

            'ind29a_no','ind29a_pct','ind29b_no','ind29b_pct','ind29c_no','ind29c_pct',
            'ind29d_no','ind29d_pct','ind29e_no','ind29e_pct','ind29f_no','ind29f_pct',
            'ind29g_no','ind29g_pct',

            'ind30a_no','ind30a_pct','ind30b_no','ind30b_pct','ind30c_no','ind30c_pct',
            'ind30d_no','ind30d_pct',

            'ind31a_no','ind31a_pct','ind31b_no','ind31b_pct','ind31c_no','ind31c_pct',
            'ind31d_no','ind31d_pct','ind31e_no','ind31e_pct','ind31f_no','ind31f_pct',

            'ind32_no', 'ind32_pct',
            'ind33_no','ind33_pct',
            'ind34_no','ind34_pct',
            'ind35_no','ind35_pct',
            'ind36_no','ind36_pct',
            'ind37a','ind37b','ind38'
        ];

        let valueIndex = 0;
        let missing = false;

        // fill fields
        inputMapping.forEach(name => {
            const el = document.querySelector(`[name="${name}"]`);
            if (!el) return;

            let val = values[valueIndex] || '';
            el.value = val;

            if (val === '') {
                missing = true;
                el.style.border = "2px solid red";
            }

            valueIndex++;
        });

        const submitBtn = document.querySelector(".submit-btn");

        if (missing) {
            alert("⚠ Some fields are missing. Please import a COMPLETE CSV file.");
            submitBtn.disabled = true;
            disableInputs(); // lock fields to prevent partial submission
        } else {
            alert("✅ Import successful. Fields are now locked.");
            submitBtn.disabled = false;
            disableInputs(); // lock fields
        }

        checkManualCompletion(); // re-check completeness
    };

    reader.readAsText(file);
});


// ✅ Disable kapag successful import
function disableInputs() {
    document.querySelectorAll("input").forEach(input => {
        if (input.id !== "csvFile") { 
            input.disabled = true;
        }
    });
}

// ✅ Enable inputs kapag error / manual mode
function enableInputs() {
    document.querySelectorAll("input").forEach(input => {
        input.disabled = false;
    });
}

// ✅ Remove error borders
function clearBorders() {
    document.querySelectorAll("input").forEach(input => {
        input.style.border = "";
    });
}


// ✅ MANUAL MODE CHECKER (AUTO ENABLE SUBMIT)
document.querySelectorAll("input").forEach(input => {
    if (input.type !== "file" && input.type !== "submit") {
        input.addEventListener("input", checkManualCompletion);
    }
});

function checkManualCompletion() {
    const required = document.querySelectorAll("input[required]");
    let isComplete = true;

    required.forEach(input => {
        if (!input.disabled && input.value.trim() === '') {
            isComplete = false;
        }
    });

    const submitBtn = document.querySelector(".submit-btn");
    submitBtn.disabled = !isComplete;
}

// Copy Report Title to hidden field
function copyTitle() {
    document.getElementById('hidden-title').value = 
        document.getElementById('report-title').value;
}

// Synchronize Number of Population fields
document.addEventListener("DOMContentLoaded", function() {

    // For the Number of Population inputs
    const totalInput = document.getElementById('total');
    const maleInput = document.getElementById('male');
    const femaleInput = document.getElementById('female');

    let isUpdating = false;

    // Update total automatically when male or female changes
    function updateTotalFromParts() {
      if (isUpdating) return;
      isUpdating = true;

      const male = parseInt(maleInput.value) || 0;
      const female = parseInt(femaleInput.value) || 0;
      totalInput.value = male + female;

      isUpdating = false;
    }

    // Adjust Male or Female proportionally when total changes
  //  function adjustPartsFromTotal() {
      if (isUpdating) return;
      isUpdating = true;

      const total = parseInt(totalInput.value) || 0;
      let male = parseInt(maleInput.value) || 0;
      let female = parseInt(femaleInput.value) || 0;
      const sum = male + female;

      isUpdating = false;
   // }

    // Prevent negative values or overflows
    function validateInputs() {
      const total = parseInt(totalInput.value) || 0;
      const male = parseInt(maleInput.value) || 0;
      const female = parseInt(femaleInput.value) || 0;

      if (male < 0) maleInput.value = 0;
      if (female < 0) femaleInput.value = 0;
      if (total < 0) totalInput.value = 0;

      if (male + female > total) {
        adjustPartsFromTotal();
      }
    }

    maleInput.addEventListener('input', () => { updateTotalFromParts(); validateInputs(); });
    femaleInput.addEventListener('input', () => { updateTotalFromParts(); validateInputs(); });
    totalInput.addEventListener('input', adjustPartsFromTotal);

});

// ✅ Auto-generate Report Title
document.addEventListener("DOMContentLoaded", function () {
    const titleInput = document.querySelector('[name="title"]');
    const barangayInput = document.querySelector('[name="barangay"]'); // ⚠ change if different

    if (!titleInput) return;

    const now = new Date();
    const month = now.toLocaleString("default", { month: "long" });
    const year = now.getFullYear();

    let barangay = "";
    if (barangayInput && barangayInput.value.trim() !== "") {
        barangay = "Barangay " + barangayInput.value.trim();
    }

    if (titleInput.value.trim() === "") {
        if (barangay !== "") {
            titleInput.value = "New Report: " + barangay + " – " + month + " " + year;
        } else {
            titleInput.value = "New Report: " + month + " " + year;
        }
    }
});

