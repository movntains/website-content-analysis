import { type ClassValue, clsx } from 'clsx';
import { format } from 'date-fns';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]): string {
  return twMerge(clsx(inputs));
}

export function formatDate(date?: string): string {
  if (!date) {
    return '-';
  }

  const parsedDate = new Date(date);

  if (isNaN(parsedDate.getTime())) {
    return '-';
  }

  return format(parsedDate, 'MM/dd/yy, h:mm a');
}
