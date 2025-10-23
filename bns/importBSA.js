function importCSVFile(inputId = "csvFile") {
  const fileInput = document.getElementById(inputId);
  const file = fileInput.files[0];
  if (!file) {
    alert("Please select a CSV file first.");
    return;
  }

  const reader = new FileReader();
  reader.onload = function (e) {
    let text = e.target.result;

    // Replace multiple tabs with a single comma (for Excel tab-based CSV)
    text = text.replace(/\t+/g, ",");

    // Split lines
    const lines = text.split(/\r?\n/);

    // Find where "Indicator" starts (to skip the headers)
    const startIndex = lines.findIndex(line => line.toLowerCase().includes("indicator"));
    if (startIndex === -1) {
      alert("No 'Indicator' header found in CSV file.");
      return;
    }

    let dataLines = lines.slice(startIndex + 1);
    let filled = 0;
    let inputIndex = 1; // corresponds to ind1, ind2, etc.

    for (let line of dataLines) {
      line = line.trim();
      if (line === "") continue;

      // Split by comma
      const parts = line.split(",");

      // Get the last numeric value in the line
      let value = null;
      for (let i = parts.length - 1; i >= 0; i--) {
        const match = parts[i].match(/\d+(\.\d+)?/);
        if (match) {
          value = match[0];
          break;
        }
      }

      // Skip lines without numbers
      if (!value) continue;

      // Find corresponding input field (by order)
      const input = document.querySelector(`[name="ind${inputIndex}"]`);
      if (input) {
        input.value = value;
        filled++;
      }
      inputIndex++;
    }

    alert(`Import complete. ${filled} fields filled.`);
  };

  reader.readAsText(file);
}
