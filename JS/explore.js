const year = document.querySelector("#year");
const collatzForm = document.querySelector("#collatz-form");
const input = document.querySelector("#collatz-input");
const error = document.querySelector("#calculator-error");
const sequenceLength = document.querySelector("#sequence-length");
const highestValue = document.querySelector("#highest-value");
const sequenceOutput = document.querySelector("#sequence-output");

year.textContent = new Date().getFullYear();

collatzForm.addEventListener("submit", (event) => {
  event.preventDefault();

  try {
    const startingValue = BigInt(input.value);

    if (startingValue < 1n) {
      throw new Error("Enter a positive integer.");
    }

    const sequence = [startingValue];
    let currentValue = startingValue;

    while (currentValue !== 1n && sequence.length < 100000) {
      currentValue = currentValue % 2n === 0n
        ? currentValue / 2n
        : currentValue * 3n + 1n;
      sequence.push(currentValue);
    }

    if (currentValue !== 1n) {
      throw new Error("That sequence is taking too long to finish.");
    }

    const maximum = sequence.reduce((highest, value) => value > highest ? value : highest);
    sequenceLength.textContent = sequence.length - 1;
    highestValue.textContent = maximum.toString();
    sequenceOutput.textContent = sequence.join(" ");
    error.textContent = "";
  } catch (calculationError) {
    sequenceLength.textContent = "--";
    highestValue.textContent = "--";
    sequenceOutput.textContent = "Enter a number to see the sequence.";
    error.textContent = calculationError.message;
  }
});