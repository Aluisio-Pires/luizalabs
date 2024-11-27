<template>
    <input
        ref="input"
        type="text"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="displayValue"
        @input="handleInput"
        @blur="handleBlur"
        @keydown="handleKeyDown"
    />
</template>

<script setup>
import { onMounted, ref, defineProps, defineEmits, computed } from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const displayValue = computed(() => {
    if (props.modelValue === "" || props.modelValue === null) {
        return "";
    }
    return props.modelValue.replace(".", ",");
});

const MAX_VALUE = 9999999999999.99;

const handleInput = (event) => {
    let value = event.target.value;

    value = value.replace(",", ".");

    value = value.replace(/[^\d.,]/g, "");

    if ((value.match(/[.,]/g) || []).length > 1) {
        value = value.slice(
            0,
            value.lastIndexOf(".") > value.lastIndexOf(",")
                ? value.lastIndexOf(".")
                : value.lastIndexOf(","),
        );
    }

    const parts = value.split(/[.,]/);
    if (parts[1] && parts[1].length > 2) {
        value = parts[0] + "." + parts[1].slice(0, 2);
    }

    let numericValue = parseFloat(value.replace(",", "."));
    if (numericValue > MAX_VALUE) {
        numericValue = MAX_VALUE;
    }

    emit(
        "update:modelValue",
        isNaN(numericValue) ? "" : numericValue.toString(),
    );
};

const handleBlur = () => {
    if (props.modelValue === "") return;

    let numericValue = parseFloat(props.modelValue);

    if (isNaN(numericValue)) {
        emit("update:modelValue", "");
    } else {
        numericValue = Math.min(numericValue, MAX_VALUE).toFixed(2);
        emit("update:modelValue", numericValue);
    }
};

const handleKeyDown = (event) => {
    const currentValue = event.target.value;

    if (
        !/[0-9.,]/.test(event.key) &&
        !["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"].includes(
            event.key,
        )
    ) {
        event.preventDefault();
    }

    if (
        (event.key === "." || event.key === ",") &&
        (currentValue.includes(".") || currentValue.includes(","))
    ) {
        event.preventDefault();
    }

    const decimalIndex =
        currentValue.indexOf(".") > -1
            ? currentValue.indexOf(".")
            : currentValue.indexOf(",");
    if (
        decimalIndex !== -1 &&
        currentValue.length - decimalIndex > 2 &&
        /[0-9]/.test(event.key)
    ) {
        event.preventDefault();
    }

    const nextValue = currentValue + event.key;
    let numericValue = parseFloat(
        nextValue.replace(",", ".").replace(/[^\d.]/g, ""),
    );
    if (!isNaN(numericValue) && numericValue > MAX_VALUE) {
        event.preventDefault();
    }
};
</script>
