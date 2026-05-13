import {
    ResponsiveContainer,
    LineChart,
    Line,
    CartesianGrid,
    XAxis,
    Tooltip,
} from 'recharts';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

const weeklyData = [
    { day: 'Mon', transactions: 120 },
    { day: 'Tue', transactions: 180 },
    { day: 'Wed', transactions: 140 },
    { day: 'Thu', transactions: 220 },
    { day: 'Fri', transactions: 190 },
    { day: 'Sat', transactions: 260 },
    { day: 'Sun', transactions: 210 },
];

const currentDay = new Date().getDay();
const adjustedDay = currentDay === 0 ? 7 : currentDay;
const data = weeklyData.slice(0, adjustedDay);

export function TransactionChart() {
    return (
        <Card className="h-full rounded-2xl border-border/60 shadow-sm">
            <CardHeader className="flex flex-row items-center justify-between space-y-0">
                <div>
                    <CardTitle className="text-lg font-semibold">
                        Transaction Trends
                    </CardTitle>

                    <p className="mt-1 text-sm text-muted-foreground">
                        Weekly warehouse activity overview
                    </p>
                </div>

                <div className="text-sm text-muted-foreground">Last 7 Days</div>
            </CardHeader>

            <CardContent className="h-[260px] pt-4">
                <ResponsiveContainer width="100%" height="100%">
                    <LineChart
                        data={data}
                        margin={{
                            top: 10,
                            right: 12,
                            left: -18,
                            bottom: 0,
                        }}
                    >
                        <CartesianGrid
                            strokeDasharray="3 3"
                            vertical={false}
                            className="stroke-muted"
                        />

                        <XAxis
                            dataKey="day"
                            axisLine={false}
                            tickLine={false}
                            interval={0}
                            tickMargin={12}
                            padding={{ left: 30, right: 8 }}
                            tick={{
                                fontSize: 12,
                            }}
                        />

                        <Tooltip />

                        <Line
                            type="linear"
                            dataKey="transactions"
                            stroke="var(--primary)"
                            strokeWidth={3}
                            dot={{
                                r: 3,
                                fill: 'var(--primary)',
                                strokeWidth: 0,
                            }}
                            activeDot={{
                                r: 5,
                            }}
                        />
                    </LineChart>
                </ResponsiveContainer>
            </CardContent>
        </Card>
    );
}
