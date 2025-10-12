export enum ScanStatus {
  PENDING = 'pending',
  PROCESSING = 'processing',
  COMPLETED = 'completed',
  FAILED = 'failed',
}

export interface ScanOverview {
  uuid: string;
  domainName: string;
  url: string;
  status: ScanStatus;
  createdAt: string;
}
