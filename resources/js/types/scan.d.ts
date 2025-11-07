import { ScanStatusEnum } from '@/types/enums/scan';

// @see /app/Http/Resources/ScanOverviewResource.php
export interface ScanOverview {
  uuid: string;
  domainName: string;
  url: string;
  status: ScanStatusEnum;
  createdAt: string;
}

// @see /app/Http/Resources/ScanDetailsResource.php
export interface ScanDetails {
  uuid: string;
  url: string;
  status: ScanStatusEnum;
  createdAt: string;
  scores: {
    clarity: string;
    consistency: string;
    seo: string;
    tone: string;
  };
  analysis: {
    clarity: string;
    consistency: string;
    seo: string;
    tone: string;
  };
}
