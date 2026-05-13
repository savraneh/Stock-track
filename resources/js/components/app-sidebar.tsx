import { Link } from '@inertiajs/react';

import {
    Activity,
    ArrowLeftRight,
    BarChart3,
    FileText,
    FolderTree,
    LayoutDashboard,
    Package,
} from 'lucide-react';

import AppLogo from '@/components/app-logo';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
    },
    {
        title: 'Items',
        href: '/items',
        icon: Package,
    },
    {
        title: 'Categories',
        href: '/categories',
        icon: FolderTree,
    },
    {
        title: 'Transactions',
        href: '/transactions',
        icon: ArrowLeftRight,
    },
    {
        title: 'Stock Monitoring',
        href: '/monitoring',
        icon: Activity,
    },
    {
        title: 'Demand Analytics',
        href: '/analytics',
        icon: BarChart3,
    },
    {
        title: 'Reports',
        href: '/reports',
        icon: FileText,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            {/* HEADER */}
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard">
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            {/* MAIN NAVIGATION */}
            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            {/* FOOTER */}
            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
