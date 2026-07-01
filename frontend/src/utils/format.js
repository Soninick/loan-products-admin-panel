export function formatList(value) {
  if (Array.isArray(value)) {
    return value.join(', ');
  }

  if (typeof value === 'string' && value.length > 0) {
    return value;
  }

  return '-';
}

export function formatMoney(value) {
  if (value === null || value === undefined || value === '') {
    return '-';
  }

  const number = Number(value);

  if (Number.isNaN(number)) {
    return '-';
  }

  return new Intl.NumberFormat('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(number);
}
